<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
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

       public function indexUser()
    {
        $products = Product::all();
        return view('pages.product', compact('products'));
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
        $product = Product::findOrFail($id);

        $request->validate([
            'name_product' => 'required|string|max:255',
            'brand'        => 'required|in:hotw,minigt,poprace,tomica,mbx',
            'description'  => 'required|string',
            'link'         => 'required|url',
            'photos.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $oldPhotos = explode(',', $product->photo);
        $keptPhotos = $request->old_photos ?? [];

        foreach ($oldPhotos as $photo) {
            if (!in_array($photo, $keptPhotos)) {
                $path = public_path($photo);

                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }

        $paths = $keptPhotos;

        if ($request->hasFile('photos')) {
            $index = count($paths) + 1;

            foreach ($request->file('photos') as $file) {
                if (count($paths) >= 3) break;

                $ext = $file->getClientOriginalExtension();
                $filename = $product->id_product . '(' . $index . ')-' . time() . '.' . $ext;

                $file->move(public_path('produk'), $filename);
                $paths[] = 'produk/' . $filename;

                $index++;
            }
        }

        if (count($paths) < 1) {
            return back()->withErrors('Minimal 1 foto');
        }

        $product->update([
            'name_product' => $request->name_product,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'link'         => $request->link,
            'photo'        => implode(',', $paths)
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $photos = explode(',', $product->photo);

        foreach ($photos as $photo) {
            $path = public_path($photo);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
