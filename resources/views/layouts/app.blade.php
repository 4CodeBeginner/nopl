<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .sidebar-footer {
            padding: 15px;
            font-size: 12px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #343a40;
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
                class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">

                <i class="bi bi-cart-check"></i>
                Penjualan
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <div id="submenu" class="submenu {{ request()->routeIs('sales.*') ? 'show' : '' }}">

                <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">
                    <i class="bi bi-list"></i>
                    Data Penjualan
                </a>

                <a href="#">
                    <i class="bi bi-bar-chart"></i>
                    Statistik
                </a>

                <a href="#">
                    <i class="bi bi-receipt"></i>
                    Detail Penjualan
                </a>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="sidebar-footer">
            <div>Inventory System</div>
            <div>v1.0</div>
        </div>

    </div>

    <!-- MAIN -->
    <div id="main" class="main-content">

        <!-- NAVBAR -->
        <nav class="navbar navbar-light navbar-custom mb-4">
            <div class="d-flex align-items-center">

                <button class="toggle-btn me-3" onclick="toggleSidebar()">☰</button>

                <span class="navbar-brand mb-0 fw-semibold">
                    @if (request()->routeIs('products.*'))
                        Manajemen Produk
                    @elseif(request()->routeIs('sales.*'))
                        Manajemen Penjualan
                    @else
                        Dashboard
                    @endif
                </span>

            </div>
        </nav>

        @yield('content')

    </div>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('hide');
            document.getElementById('main').classList.toggle('full');
        }

        function toggleDropdown(e) {
            e.stopPropagation();
            document.getElementById('submenu').classList.toggle('show');
        }
    </script>

</body>

</html>
