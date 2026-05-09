<div class="product-card">
    <div class="card-image">
       <img src="/{{ explode(',', $image)[0] }}" alt="default">
    </div>

    <div class="card-body">
        <h3 class="product-name">{{ $name }}</h3>
        <p class="product-brand">{{ $brand }}</p>
        <p class="product-price">Rp {{ number_format($price,0, ',', '.')}} </p>
            <div class="card-footer">
                <a href="{{ $marketplaceLink }}"
                target="_blank"
                class="market-btn">
                    Beli Sekarang
                </a>
            </div>
    </div>
  
</div>