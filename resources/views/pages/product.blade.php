<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>

<body>

    @extends('layouts.guest')
    @section('content')
    <div class="product-container">

        @if (isset($searchTerm))
            <p class="search-summary">
                {{ ($isVisualSearch ?? false) ? 'Hasil Visual Search untuk:' : 'Hasil pencarian untuk:' }}
                <strong>{{ $searchTerm }}</strong>
            </p>
        @endif

        <form method="GET" class="filter-form">

    <select name="brand" onchange="this.form.submit()">

        <option value="">Semua Brand</option>

        <option value="HOTW" 
            {{ strtolower(request('brand', '')) == 'hotw' ? 'selected' : '' }}>
            HOTWHEELS
        </option>

        <option value="TOMICA"
            {{ strtolower(request('brand', '')) == 'tomica' ? 'selected' : '' }}>
            TOMICA
        </option>

        <option value="POPRACE"
            {{ strtolower(request('brand', '')) == 'poprace' ? 'selected' : '' }}>
            POPRACE
        </option>
         <option value="MINIGT"
            {{ strtolower(request('brand', '')) == 'minigt' ? 'selected' : '' }}>
            MINIGT
        </option>

    </select>

</form>
        <div class="product-grid">
    @forelse ($products as $product)
                <x-product-card
                    :image="$product->photo"
                    :name="$product->name_product"
                    :brand="$product->brand"
                    :price="$product->price"
                    :description="$product->description"
                    :marketplaceLink="$product->link"
                    />
    @empty
        <p class="search-empty">Produk tidak ditemukan. Coba kata kunci atau gambar lain.</p>
    @endforelse
</div>
</div>
    @endsection


</body>

</html>
