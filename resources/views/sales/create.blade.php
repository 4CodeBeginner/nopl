@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 14px;
            border: none;
        }

        .table {
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #212529;
            color: #fff;
        }

        .btn-sm {
            border-radius: 8px;
        }

        .price-col {
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
            font-weight: 500;
        }

        .customer-name {
            font-weight: 600;
        }

        .resi {
            font-size: 13px;
            color: #888;
        }

        .nested-table {
            border: 1px solid #dee2e6;
            background: #fbfbfb;
            border-radius: 10px;
            overflow: hidden;
        }

        .nested-table td {
            font-size: 13px;
            padding: 6px;
            border: 1px solid #dee2e6;
        }

        .qty-text {
            font-weight: 500;
            color: #333;
        }

        .total-text {
            font-weight: 600;
            color: #198754;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold">Data Penjualan</h4>

        <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm">
            + Tambah Penjualan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- SEARCH (TAMBAHAN SAJA) -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Cari nama customer atau resi...">
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Customer & Resi</th>
                            <th>Detail Produk</th>
                            <th>Total</th>
                            <th width="120px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="salesTable">
                        @include('sales.partials.table', ['sales' => $sales])
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- AJAX SEARCH -->
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('sales.search') }}?q=${query}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('salesTable').innerHTML = html;
                });
        });
    </script>
@endsection
