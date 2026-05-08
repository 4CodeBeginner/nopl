<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>NOPL DIECAST</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #212529;
            color: white;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar.hide {
            margin-left: -250px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #0d6efd;
            color: white;
        }

        .logo {
            text-align: center;
            padding: 20px 10px;
            border-bottom: 1px solid #343a40;
        }

        .logo img {
            width: 70px;
            border-radius: 10px;
        }

        .menu {
            flex: 1;
        }

        .submenu {
            display: none;
            background: #2c3034;
        }

        .submenu a {
            padding-left: 45px;
            font-size: 14px;
        }

        .submenu.show {
            display: block;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: 0.3s;
        }

        .main-content.full {
            margin-left: 0;
        }

        .navbar-custom {
            background: white;
            border-bottom: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px 15px;
        }

        .toggle-btn {
            border: none;
            background: transparent;
            font-size: 20px;
        }

        .sidebar form button {
            border-radius: 10px;
            height: 40px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">

        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('img/emstoys.png') }}">
            <div class="mt-2 fw-semibold">NOPL DIECAST</div>
        </div>

        <!-- MENU -->
        <div class="menu">

            <!-- PRODUK -->
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Produk
            </a>

            <!-- PENJUALAN -->
            <a href="javascript:void(0)" onclick="toggleDropdown(event)"
                class="{{ request()->routeIs('sales.*') || request()->routeIs('dashboard.stats') ? 'active' : '' }}">

                <i class="bi bi-cart-check"></i>
                Penjualan
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <div id="submenu"
                class="submenu {{ request()->routeIs('sales.*') || request()->routeIs('dashboard.stats') ? 'show' : '' }}">

                <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    Data Penjualan
                </a>

                <a href="{{ route('dashboard.stats') }}"
                    class="{{ request()->routeIs('dashboard.stats') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i>
                    Statistik Penjualan
                </a>

            </div>

        </div>

        <!-- LOGOUT -->
        <div class="px-3 pb-3">

            <form action="/logout" method="POST">
                @csrf

                <button type="submit"
                    class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">

                    <i class="bi bi-box-arrow-right"></i>
                    Logout

                </button>
            </form>

        </div>

    </div>

    <!-- MAIN -->
    <div id="main" class="main-content">

        <!-- NAVBAR -->
        <nav class="navbar navbar-light navbar-custom mb-4">
            <div class="d-flex align-items-center">

                <button class="toggle-btn me-3" onclick="toggleSidebar()" title="Buka / Tutup Sidebar">

                    <i id="sidebarIcon" class="bi bi-layout-sidebar-inset fs-4"></i>

                </button>

                <span class="navbar-brand mb-0 fw-semibold">

                    @if (request()->routeIs('products.*'))
                        Manajemen Produk
                    @elseif(request()->routeIs('sales.create'))
                        Tambah Penjualan
                    @elseif(request()->routeIs('sales.index'))
                        Manajemen Penjualan
                    @elseif(request()->routeIs('dashboard.stats'))
                        Statistik Penjualan
                    @else
                        Halaman Tidak Ada
                    @endif

                </span>

            </div>
        </nav>

        @yield('content')

    </div>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {

            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const icon = document.getElementById('sidebarIcon');

            sidebar.classList.toggle('hide');
            main.classList.toggle('full');

            if (sidebar.classList.contains('hide')) {

                icon.classList.remove('bi-layout-sidebar-inset');
                icon.classList.add('bi-layout-sidebar');

            } else {

                icon.classList.remove('bi-layout-sidebar');
                icon.classList.add('bi-layout-sidebar-inset');

            }
        }

        function toggleDropdown(event) {

            event.stopPropagation();

            document.getElementById('submenu')
                .classList.toggle('show');
        }

        history.pushState(null, null, location.href);

        window.onpopstate = function() {
            history.go(1);
        };

        window.addEventListener('pageshow', function(event) {

            if (event.persisted) {
                window.location.reload();
            }

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
