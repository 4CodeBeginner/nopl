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
            ->latest()
            ->get();

        return view('sales.partials.rows', compact('sales'))->render();
    }

    public function stats()
    {
        $totalOmzet = DB::table('sales')->sum('total_amount');

        $totalTransaksi = DB::table('sales')->count();

        $totalQty = DB::table('sale_details')->sum('quantity');

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

        $salesMonthly = DB::table('sales')
            ->select(
                DB::raw("DATE_FORMAT(sale_date, '%b %Y') as month"),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy(DB::raw("DATE_FORMAT(sale_date, '%b %Y')"))
            ->orderBy(DB::raw("MIN(sale_date)"))
            ->get();

        return view('sales.stats', compact(
            'totalOmzet',
            'totalTransaksi',
            'totalQty',
            'topProducts',
            'salesMonthly'
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
            'customer_name' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100|unique:sales,tracking_number',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1'
        ], [
            'tracking_number.unique' => 'Nomor resi sudah digunakan'
        ]);

        DB::beginTransaction();

        try {

            $total = 0;

            $sale = \App\Models\Sale::create([
                'sale_date' => now(),
                'customer_name' => $request->customer_name,
                'tracking_number' => $request->tracking_number,
                'total_amount' => 0
            ]);

            foreach ($request->product_id as $i => $productId) {

                $qty = $request->qty[$i];

                $product = Product::findOrFail($productId);

                if ($product->qty < $qty) {
                    throw new \Exception("Stok produk {$product->name_product} tidak mencukupi");
                }

                $subtotal = $product->price * $qty;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ]);

                $product->decrement('qty', $qty);

                $total += $subtotal;
            }

            $sale->update([
                'total_amount' => $total
            ]);

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::with('details')->findOrFail($id);

            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);

                if ($product) {
                    $product->increment('qty', $detail->quantity);
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
