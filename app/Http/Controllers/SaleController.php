<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('details.product')->latest()->get();
        return view('sales.index', compact('sales'));
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
            'products' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
        ]);

        $sale = Sale::create([
            'sale_date' => now(),
            'customer_name' => $request->customer_name,
            'tracking_number' => $request->tracking_number,
            'total_amount' => 0
        ]);

        $total = 0;

        foreach ($request->products as $i => $product_id) {

            if (!$request->qty[$i] || !$request->price[$i]) continue;

            $qty = $request->qty[$i];
            $price = $request->price[$i];
            $subtotal = $qty * $price;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product_id,
                'quantity' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;
        }

        $sale->update([
            'total_amount' => $total
        ]);

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil ditambahkan');
    }

    public function show($id)
    {
        $sale = Sale::with('details.product')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dihapus');
    }
}
