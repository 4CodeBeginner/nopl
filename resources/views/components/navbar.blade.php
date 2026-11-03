<div class="navbar">

    <div class="nav-left">
        <img class="logo" src="{{ asset('img/emstoys.png') }}" alt="logo">
        <button class="hamburger" id="hamburger-btn">
            ☰
        </button>

        <div class="nav-menu" id="nav-menu">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}" data-color="#39d353">Home</a>

            <div class="nav-dropdown">
                <a href="/product"
                    class="nav-link {{ request()->is('product') ? 'active' : '' }}"data-color="#2196f3">Product</a>
                <div class="dropdown-menu">
                    <a href="/product?brand=HOTW">
                        <img src="/img/HotWheelsLogo.png" alt="">
                    </a>

                    <a href="/product?brand=TOMICA">
                        <img src="/img/Tomica.png" alt="">
                    </a>

                    <a href="/product?brand=POPRACE">
                        <img src="/img/PopRace.png" alt="">
                    </a>

                    <a href="/product?brand=MINIGT">
                        <img src="/img/MiniGT.png" alt="">
                    </a>
                </div>
            </div>
            <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}" data-color="#f5c400">About
                Us</a>
            <a href="/contact" class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                data-color="#ff3b30">Contact Us</a>
            <span class="nav-indicator"></span>
        </div>

        <form class="nav-search" action="{{ route('product.search') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (request()->filled('brand'))
                <input type="hidden" name="brand" value="{{ request('brand') }}">
            @endif
            <label class="visually-hidden" for="nav-search-query">Cari produk</label>
            <input id="nav-search-query" type="search" name="q" value="{{ request('q', $searchTerm ?? '') }}"
                placeholder="Cari produk..." maxlength="255">
            <button type="submit" class="nav-search-submit">Cari</button>
            <label class="nav-search-image" for="nav-search-image" title="Cari dengan gambar">
                <span>Visual Search</span>
            </label>
            <input class="visually-hidden" id="nav-search-image" type="file" name="image"
                accept="image/jpeg,image/png,image/webp">
            @if ($errors->has('search') || $errors->has('image') || $errors->has('q'))
                <span class="nav-search-error" role="alert">
                    {{ $errors->first('search') ?: $errors->first('image') ?: $errors->first('q') }}
                </span>
            @endif
        </form>
    </div>
</div>

<script>
    const navSearchImage = document.getElementById('nav-search-image');
    navSearchImage.addEventListener('change', () => {
        if (navSearchImage.files.length > 0) {
            navSearchImage.form.requestSubmit();
        }
    });

    if (window.innerWidth > 600) {
        const navMenu =
            document.querySelector('.nav-menu');

        const indicator =
            document.querySelector('.nav-indicator');

        function moveIndicator(element) {

            const menuRect =
                navMenu.getBoundingClientRect();

            const elementRect =
                element.getBoundingClientRect();

            indicator.style.width =
                `${elementRect.width}px`;

            indicator.style.left =
                `${elementRect.left - menuRect.left}px`;
        }

        function setActiveIndicator() {

            const activeLink =
                document.querySelector('.nav-link.active');

            if (!activeLink) return;

            moveIndicator(activeLink);

            indicator.style.backgroundColor =
                activeLink.dataset.color;
        }

        window.addEventListener('load', () => {

            setActiveIndicator();

        });

        window.addEventListener('resize', () => {

            setActiveIndicator();

        });

    }
</script>
