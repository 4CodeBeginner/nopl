@php
$brandName = match($brand){
    'hotw' => 'Hot Wheels',
    'minigt' => 'Mini GT',
    'poprace' => 'Pop Race',
    'tomica' => 'Tomica',
    'mbx' => 'MatchBox',
    default => $brand
};
$photos = array_values(array_filter(array_map('trim', explode(',', (string) $image))));
$photoUrls = array_map(fn ($photo) => asset($photo), $photos);
@endphp
<article class="product-card">
    <div class="card-image" data-photo-gallery data-photos='@json($photoUrls)' data-photo-index="0">
        @if (count($photos) > 0)
            <img src="{{ asset($photos[0]) }}" alt="{{ $name }}">
        @else
            <div class="card-image-placeholder">Foto belum tersedia</div>
        @endif

        @if (count($photos) > 1)
            <button class="photo-nav photo-nav-prev" type="button" aria-label="Lihat foto sebelumnya">&lsaquo;</button>
            <button class="photo-nav photo-nav-next" type="button" aria-label="Lihat foto berikutnya">&rsaquo;</button>
            <span class="photo-counter" aria-live="polite">1 / {{ count($photos) }}</span>
        @endif
    </div>

    <div class="card-body">
        <h3 class="product-name">{{ $name }}</h3>
        <p class="product-brand">{{ $brandName }}</p>
        <p class="product-price">Rp {{ number_format($price, 0, ',', '.') }}</p>

        <div class="card-footer">
            <button class="detail-btn" type="button" data-open-product-detail>
                Detail
            </button>
            <a href="{{ $marketplaceLink }}" target="_blank" rel="noopener noreferrer" class="market-btn">
                Beli Sekarang
            </a>
        </div>
    </div>

    <dialog class="product-detail-dialog" aria-label="Detail barang">
        <div class="detail-dialog-header">
            <h2>Detail Barang</h2>
            <button class="detail-close" type="button" data-close-product-detail aria-label="Tutup detail">&times;</button>
        </div>
        <div class="detail-dialog-content">
            @if (count($photoUrls) > 0)
                <div class="detail-product-gallery" data-photo-gallery data-photos='@json($photoUrls)' data-photo-index="0">
                    <button class="detail-image-open" type="button" data-open-image-viewer aria-label="Perbesar foto {{ $name }}">
                        <img src="{{ $photoUrls[0] }}" alt="{{ $name }}">
                        <span class="image-zoom-hint">Klik foto untuk memperbesar</span>
                    </button>
                    @if (count($photoUrls) > 1)
                        <button class="photo-nav photo-nav-prev" type="button" data-photo-direction="-1" aria-label="Lihat foto sebelumnya">&lsaquo;</button>
                        <button class="photo-nav photo-nav-next" type="button" data-photo-direction="1" aria-label="Lihat foto berikutnya">&rsaquo;</button>
                        <span class="photo-counter" aria-live="polite">1 / {{ count($photoUrls) }}</span>
                    @endif
                </div>
            @endif
            <p><strong>Nama:</strong> {{ $name }}</p>
            <p><strong>Brand:</strong> {{ $brandName }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($price, 0, ',', '.') }}</p>
            <div class="detail-description">
                <strong>Deskripsi:</strong>
                <p>{{ filled($description) ? $description : 'Belum ada deskripsi untuk barang ini.' }}</p>
            </div>
        </div>
        <div class="detail-dialog-footer">
            <button class="detail-btn" type="button" data-close-product-detail>Tutup</button>
        </div>
    </dialog>

    @if (count($photoUrls) > 0)
        <dialog class="product-image-dialog" aria-label="Galeri foto {{ $name }}">
            <button class="detail-close image-viewer-close" type="button" data-close-product-image aria-label="Tutup foto">&times;</button>
            @if (count($photoUrls) > 1)
                <button class="photo-nav photo-nav-prev" type="button" data-viewer-direction="-1" aria-label="Lihat foto sebelumnya">&lsaquo;</button>
                <button class="photo-nav photo-nav-next" type="button" data-viewer-direction="1" aria-label="Lihat foto berikutnya">&rsaquo;</button>
            @endif
            <img class="product-image-full" src="{{ $photoUrls[0] }}" alt="{{ $name }}">
            @if (count($photoUrls) > 1)
                <span class="photo-counter image-viewer-counter" aria-live="polite">1 / {{ count($photoUrls) }}</span>
            @endif
        </dialog>
    @endif
</article>

@once
    <script>
        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element)) return;

            const photoButton = target.closest('[data-photo-direction], [data-viewer-direction]');
            if (photoButton) {
                const gallery = photoButton.closest('[data-photo-gallery]');
                const viewer = photoButton.closest('.product-image-dialog');
                const photos = JSON.parse((gallery || viewer.closest('.product-card').querySelector('[data-photo-gallery]')).dataset.photos || '[]');
                const indexElement = gallery || viewer;
                const direction = Number(photoButton.dataset.photoDirection || photoButton.dataset.viewerDirection);
                const currentIndex = Number(indexElement.dataset.photoIndex || 0);
                const nextIndex = (currentIndex + direction + photos.length) % photos.length;

                if (gallery) {
                    updateProductGalleries(photoButton.closest('.product-card'), photos, nextIndex);
                    return;
                }

                viewer.dataset.photoIndex = nextIndex;
                viewer.querySelector('.product-image-full').src = photos[nextIndex];
                viewer.querySelector('.image-viewer-counter').textContent = `${nextIndex + 1} / ${photos.length}`;
                updateProductGalleries(viewer.closest('.product-card'), photos, nextIndex);
                return;
            }

            const openImageButton = target.closest('[data-open-image-viewer]');
            if (openImageButton) {
                const gallery = openImageButton.closest('[data-photo-gallery]');
                const viewer = openImageButton.closest('.product-card').querySelector('.product-image-dialog');
                const photos = JSON.parse(gallery.dataset.photos || '[]');
                const currentIndex = Number(gallery.dataset.photoIndex || 0);
                viewer.dataset.photoIndex = currentIndex;
                viewer.querySelector('.product-image-full').src = photos[currentIndex];
                const counter = viewer.querySelector('.image-viewer-counter');
                if (counter) counter.textContent = `${currentIndex + 1} / ${photos.length}`;
                viewer.showModal();
                return;
            }

            const cardPhotoButton = target.closest('.card-image .photo-nav');
            if (cardPhotoButton) {
                const gallery = cardPhotoButton.closest('[data-photo-gallery]');
                const photos = JSON.parse(gallery.dataset.photos || '[]');
                if (photos.length < 2) return;

                const currentIndex = Number(gallery.dataset.photoIndex || 0);
                const direction = cardPhotoButton.classList.contains('photo-nav-next') ? 1 : -1;
                const nextIndex = (currentIndex + direction + photos.length) % photos.length;
                updateProductGalleries(cardPhotoButton.closest('.product-card'), photos, nextIndex);
                return;
            }

            const openButton = target.closest('[data-open-product-detail]');
            if (openButton) {
                const productCard = openButton.closest('.product-card');
                const cardGallery = productCard.querySelector('.card-image[data-photo-gallery]');
                const detailGallery = productCard.querySelector('.detail-product-gallery');
                if (cardGallery && detailGallery) {
                    const photos = JSON.parse(detailGallery.dataset.photos || '[]');
                    updateProductGalleries(productCard, photos, Number(cardGallery.dataset.photoIndex || 0));
                }
                productCard.querySelector('.product-detail-dialog').showModal();
                return;
            }

            const closeButton = target.closest('[data-close-product-detail]');
            if (closeButton) {
                closeButton.closest('.product-detail-dialog').close();
                return;
            }

            const closeImageButton = target.closest('[data-close-product-image]');
            if (closeImageButton) {
                closeImageButton.closest('.product-image-dialog').close();
            }
        });

        document.addEventListener('click', (event) => {
            if (event.target instanceof HTMLDialogElement && event.target.matches('.product-detail-dialog, .product-image-dialog')) {
                const bounds = event.target.getBoundingClientRect();
                const outsideDialog = event.clientX < bounds.left || event.clientX > bounds.right
                    || event.clientY < bounds.top || event.clientY > bounds.bottom;
                if (outsideDialog) event.target.close();
            }
        });

        function updateProductGalleries(productCard, photos, index) {
            productCard.querySelectorAll('[data-photo-gallery]').forEach((gallery) => {
                gallery.dataset.photoIndex = index;
                gallery.querySelector('img').src = photos[index];
                const counter = gallery.querySelector('.photo-counter');
                if (counter) counter.textContent = `${index + 1} / ${photos.length}`;
            });
        }
    </script>
@endonce
