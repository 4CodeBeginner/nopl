<div class="product-card">
    <div class="card-image">
        @if ($image && file_exists(public_path($image)))
        <img src="{{ asset($image) }}" alt="{{ $name }}">
        @else
         <img src="{{ asset('img/test-gambar.png') }}" alt="default">
        @endif
    </div>

    <div class="card-body">
        <h3 class="product-name">{{ $name }}</h3>
        <p class="product-brand">{{ $brand }}</p>
        <p class="product-price">Rp {{ number_format($price,0, ',', '.')}} </p>
    </div>
</div>