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

        <form method="GET" class="filter-form">

    <select name="brand" onchange="this.form.submit()">

        <option value="">Semua Brand</option>

        <option value="HOTW" 
            {{ request('brand') == 'HOTW' ? 'selected' : '' }}>
            HOTWHEELS
        </option>

        <option value="TOMICA"
            {{ request('brand') == 'TOMICA' ? 'selected' : '' }}>
            TOMICA
        </option>

        <option value="POPRACE"
            {{ request('brand') == 'POPRACE' ? 'selected' : '' }}>
            POPRACE
        </option>
         <option value="MINIGT"
            {{ request('brand') == 'MINIGT' ? 'selected' : '' }}>
            MINIGT
        </option>

    </select>

</form>
        <div class="product-grid">
            @foreach ($products as $product)
                @php
                    $photos = explode(',', $product->photo);
                    $firstPhoto = $photos[0] ?? null;
                @endphp

                <x-product-card
                    :image="$firstPhoto"
                    :name="$product->name_product"
                    :brand="$product->brand"
                    :price="$product->price"
                    :marketplaceLink="$product->link"
                    />
                    @endforeach
</div>
</div>
    @endsection


</body>

</html>
