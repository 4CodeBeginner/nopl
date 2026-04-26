<div class="product-card">
    <div class="card-image">
        <img src="{{ $image }}" alt="{{ $name }}">
    </div>

    <div class="card-body">
        <h2 class="product-name">{{ $name }}</h2>
        <p class="product-brand">{{ $brand }}</p>
        <p class="product-price">Rp {{ number_format($price) }}</p>
    </div>


</div>