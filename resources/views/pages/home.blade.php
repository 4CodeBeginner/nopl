
    <link rel="stylesheet" href ="css/style.css">
    
    @extends('layouts.guest')
    @section('content')
    <div class="home-section">
    <div class="featured-carousel">
  
    <div class="featured-card">
        <img src="/produk/MGT-0003-080526(2).png" alt="">
    </div>

    <div class="featured-card">
        <img src="/produk/MGT-0003-080526(2).png" alt="">
    </div>

    <div class="featured-card">
        <img src="/produk/HW-0002-260426(3)-1777785283.jpg" alt="">
    </div>

    <div class="featured-card">
        <img src="/produk/HW-0002-260426(3)-1777785283.jpg" alt="">
    </div>

      <div class="featured-card">
        <img src="/produk/MGT-0003-080526(2).png" alt="">
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




