
    <link rel="stylesheet" href ="css/style.css">
    
    @extends('layouts.guest')
    @section('content')
    <div class="home-section">
    <section class="featured-carousel" aria-label="Galeri unggulan" data-featured-carousel>
        <div class="featured-viewport" data-featured-viewport>
            <div class="featured-track" data-featured-track>
                <div class="featured-group" data-featured-group>
                    <div class="featured-card"><img src="/img/carousel1.png" alt=""></div>
                    <div class="featured-card"><img src="/img/carousel2.png" alt=""></div>
                    <div class="featured-card"><img src="/img/carousel3.png" alt=""></div>
                    <div class="featured-card"><img src="/img/carousel4.png" alt=""></div>
                    <div class="featured-card"><img src="/img/carousel5.png" alt=""></div>
                    <div class="featured-card"><img src="/img/carousel6.png" alt=""></div>
                </div>
            </div>
        </div>
    </section>
    
<div class="product-grid">

@foreach($products as $product)

    <x-product-card
        :name="$product->name_product"
        :brand="$product->brand"
        :price="$product->price"
        :description="$product->description"
        :image="$product->photo"
        :marketplaceLink="$product->link"
    />

@endforeach

</div>
</div>

@once
<script>
    (() => {
        const carousel = document.querySelector('[data-featured-carousel]');
        if (!carousel) return;

        const viewport = carousel.querySelector('[data-featured-viewport]');
        const track = carousel.querySelector('[data-featured-track]');
        const originalGroup = carousel.querySelector('[data-featured-group]');
        const duplicateGroup = originalGroup.cloneNode(true);
        duplicateGroup.removeAttribute('data-featured-group');
        duplicateGroup.setAttribute('aria-hidden', 'true');
        track.prepend(duplicateGroup);

        let groupWidth = 0;
        let lastFrame = performance.now();
        let dragStartX = 0;
        let dragStartScroll = 0;
        let isDragging = false;
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        carousel.dataset.resumeAt = String(performance.now() + 2000);

        function measureGroup() {
            groupWidth = originalGroup.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap || 0);
            if (viewport.scrollLeft === 0 && groupWidth > 0) viewport.scrollLeft = groupWidth;
        }
        originalGroup.querySelectorAll('img').forEach((image) => {
            image.addEventListener('load', measureGroup, { once: true });
        });

        function pauseAutoScroll() {
            carousel.dataset.resumeAt = String(performance.now() + 2000);
        }

        viewport.addEventListener('pointerdown', (event) => {
            isDragging = true;
            dragStartX = event.clientX;
            dragStartScroll = viewport.scrollLeft;
            viewport.classList.add('is-dragging');
            viewport.setPointerCapture(event.pointerId);
            pauseAutoScroll();
        });

        viewport.addEventListener('pointermove', (event) => {
            if (!isDragging) return;
            viewport.scrollLeft = dragStartScroll - (event.clientX - dragStartX);
            pauseAutoScroll();
        });

        function finishDragging(event) {
            if (!isDragging) return;
            isDragging = false;
            viewport.classList.remove('is-dragging');
            if (viewport.hasPointerCapture(event.pointerId)) viewport.releasePointerCapture(event.pointerId);
            pauseAutoScroll();
        }

        viewport.addEventListener('pointerup', finishDragging);
        viewport.addEventListener('pointercancel', finishDragging);
        viewport.addEventListener('wheel', pauseAutoScroll, { passive: true });
        window.addEventListener('resize', measureGroup);
        measureGroup();

        function autoScroll(timestamp) {
            const elapsed = Math.min(timestamp - lastFrame, 50);
            const isPaused = isDragging || performance.now() < Number(carousel.dataset.resumeAt || 0);

            if (!reducedMotion && !isPaused && groupWidth > 0) {
                viewport.scrollLeft -= elapsed * 0.025;
                if (viewport.scrollLeft <= 0) viewport.scrollLeft += groupWidth;
            }

            lastFrame = timestamp;
            window.requestAnimationFrame(autoScroll);
        }

        window.requestAnimationFrame(autoScroll);
    })();
</script>
@endonce
@endsection
