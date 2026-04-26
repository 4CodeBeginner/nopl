<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_product' => 'required',
            'brand'        => 'required',
            'description'  => 'required',
            'link'         => 'required',
            'photos'       => 'required',
        ]);

        // Mapping prefix
        $prefixMap = [
            'hotw'   => 'HW',
            'minigt' => 'MGT',
            'poprace' => 'POP',
            'tomica' => 'TMC',
            'mbx'    => 'MBX'
        ];

        $prefix = $prefixMap[$request->brand];

        $count = Product::where('brand', $request->brand)->count() + 1;
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);
        $date = now()->format('dmy');

        $generatedId = $prefix . '-' . $number . '-' . $date;

        // Pastikan folder ada
        if (!file_exists(public_path('produk'))) {
            mkdir(public_path('produk'), 0777, true);
        }

        $paths = [];

        if ($request->hasFile('photos')) {
            $i = 1;
            foreach ($request->file('photos') as $file) {

                $filename = $generatedId . '(' . $i . ').' . $file->getClientOriginalExtension();

                $file->move(public_path('produk'), $filename);

                $paths[] = 'produk/' . $filename;

                $i++;
            }
        }

        Product::create([
            'id_product'   => $generatedId,
            'name_product' => $request->name_product,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'link'         => $request->link,
            'photo'        => implode(',', $paths)
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_product' => 'required',
            'name_product' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'link' => 'required|url',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
