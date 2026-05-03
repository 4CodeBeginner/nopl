<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('details.product')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $sales = Sale::with('details.product')
            ->where(function ($query) use ($q) {
                $query->where('customer_name', 'like', "%$q%")
                    ->orWhere('tracking_number', 'like', "%$q%");
            })
            ->orderBy('sale_date', 'desc')
            ->get();

        return view('sales.partials.rows', compact('sales'));
    }

    public function stats()
    {
        // Total omzet
        $totalOmzet = DB::table('sales')->sum('total_amount');

        // Total transaksi
        $totalTransaksi = DB::table('sales')->count();

        // Total item terjual (qty)
        $totalQty = DB::table('sale_details')->sum('quantity');

        // Produk paling laris
        $topProducts = DB::table('sale_details')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->select(
                'products.name_product',
                DB::raw('SUM(sale_details.quantity) as total_sold')
            )
            ->groupBy('sale_details.product_id', 'products.name_product')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Penjualan 7 hari terakhir
        $salesLast7Days = DB::table('sales')
            ->select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('sale_date', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(sale_date)'))
            ->orderBy('date')
            ->get();

        return view('sales.stats', compact(
            'totalOmzet',
            'totalTransaksi',
            'totalQty',
            'topProducts',
            'salesLast7Days'
        ));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'products.*'    => 'required|exists:products,id',
            'quantity.*'    => 'required|integer|min:1',
            'price.*'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // 🔥 Simpan ke tabel sales
            $sale = Sale::create([
                'customer_name' => $request->customer_name,
                'tracking_number' => $request->tracking_number,
                'total_amount' => 0
            ]);

            $total = 0;

            foreach ($request->products as $i => $productId) {

                $qty = $request->quantity[$i];
                $price = $request->price[$i];
                $subtotal = $qty * $price;

                $product = Product::findOrFail($productId);

                // ❌ CEK STOK
                if ($product->qty < $qty) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Stok produk "' . $product->name_product . '" tidak mencukupi');
                }

                // ✅ KURANGI STOK
                $product->qty -= $qty;
                $product->save();

                // ✅ SIMPAN DETAIL
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            // ✅ UPDATE TOTAL
            $sale->update([
                'total_amount' => $total
            ]);

            DB::commit();

            // ✅ REDIRECT KE INDEX (yang kamu kasih)
            return redirect()->route('sales.index')
                ->with('success', 'Penjualan berhasil disimpan');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::with('details')->findOrFail($id);

            // 🔄 KEMBALIKAN STOK
            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->qty += $detail->quantity;
                    $product->save();
                }
            }

            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menghapus data');
        }
    }
}
