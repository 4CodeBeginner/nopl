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

        .nested-table th,
        .nested-table td {
            font-size: 13px;
            padding: 6px;
            border: 1px solid #dee2e6;
        }

        .nested-table th {
            background: #f1f3f5;
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

    <!-- ===================== -->
    <!-- ✅ SEARCH (TAMBAHAN SAJA) -->
    <!-- ===================== -->
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

                    <!-- ===================== -->
                    <!-- TABEL TIDAK DIUBAH -->
                    <!-- ===================== -->
                    <tbody id="salesTable">
                        @forelse($sales as $i => $sale)
                            <tr>

                                <td class="fw-semibold">{{ $i + 1 }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="customer-name">{{ $sale->customer_name ?? '-' }}</div>
                                    <div class="resi">Resi: {{ $sale->tracking_number ?? '-' }}</div>
                                </td>

                                <td>
                                    <table class="table nested-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($sale->details as $d)
                                                <tr>
                                                    <td class="text-start">{{ $d->product->name_product }}</td>
                                                    <td>{{ $d->quantity }}</td>
                                                    <td>Rp {{ number_format($d->price, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>

                                <td class="total-text price-col">
                                    Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                </td>

                                <td>
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data penjualan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- ===================== -->
    <!-- AJAX SEARCH -->
    <!-- ===================== -->
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
