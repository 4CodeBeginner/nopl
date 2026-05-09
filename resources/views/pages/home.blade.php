
    <link rel="stylesheet" href ="css/style.css">
    
    @extends('layouts.guest')
    @section('content')
    <div class="home-section">
    <div class="featured-carousel">
  
    <div class="featured-card">
        <img src="/img/carousel1.png" alt="">
    </div>

    <div class="featured-card">
        <img src="/img/carousel2.png" alt="">
    </div>

    <div class="featured-card">
        <img src="/img/carousel3.png" alt="">
    </div>

    <div class="featured-card">
        <img src="/img/carousel4.png" alt="">
    </div>

    <div class="featured-card">
        <img src="/img/carousel5.png" alt="">
    </div>
</div>
    
<div class="product-grid">

@foreach($products as $product)

    <x-product-card
        :name="$product->name_product"
        :brand="$product->brand"
        :price="$product->price"
        :image="$product->photo"
        :marketplaceLink="$product->link"
    />

@endforeach

</div>
</div>
@endsection
