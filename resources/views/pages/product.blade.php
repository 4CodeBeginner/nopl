<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>

    @extends('layout.app')
    @section('content')


    <div class="product-container">

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
                    :price="0"

                    />
                    @endforeach
</div>


</body>
</html>