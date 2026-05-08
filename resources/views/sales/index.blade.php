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

        .customer-name {
            font-weight: 600;
        }

        .resi {
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }

        .toggle-detail {
            background: #0066ff;
            color: #fff;
            border: none;
            font-size: 12px;
        }

        .toggle-detail:hover {
            background: #005ce6;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .total-col {
            font-weight: 600;
            color: #198754;
            white-space: nowrap;
        }

        .swal-title-sm {
            font-size: 16px !important;
        }

        .swal-text-sm {
            font-size: 13px !important;
        }

        .swal-btn-sm {
            font-size: 12px !important;
            padding: 6px 12px !important;
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

    <!-- SEARCH -->
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
                            <th>Customer</th>
                            <th>Resi</th>
                            <th>Total Pembelian</th>
                            <th>Detail Pembelian</th>
                            <th width="120px">Aksi</th>
                        </tr>
                    </thead>

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

                                <td class="customer-name">
                                    {{ $sale->customer_name ?? '-' }}
                                </td>

                                <!-- 🔥 RESI LEBIH BESAR -->
                                <td class="resi">
                                    {{ $sale->tracking_number ?? '-' }}
                                </td>

                                <td class="total-col">
                                    Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                </td>

                                <td>
                                    <!-- 🔥 HAPUS ANGKA -->
                                    <button class="btn btn-sm toggle-detail d-flex align-items-center gap-2 mx-auto"
                                        onclick='showDetail({
                                            tanggal: "{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y H:i') }}",
                                            customer: "{{ $sale->customer_name ?? '-' }}",
                                            resi: "{{ $sale->tracking_number ?? '-' }}",
                                            total: "Rp {{ number_format($sale->total_amount, 0, ',', '.') }}",
                                            details: [
                                                @foreach ($sale->details as $d)
                                                        {
                                                            produk: "{{ $d->product->name_product ?? 'Produk telah dihapus' }}",
                                                            qty: "{{ $d->quantity }}",
                                                            harga: "Rp {{ number_format($d->price, 0, ',', '.') }}",
                                                            subtotal: "Rp {{ number_format($d->subtotal, 0, ',', '.') }}"
                                                        }, @endforeach
                                                ]
                                        })'>

                                        <i class="bi bi-eye"></i>
                                        <span>Detail</span>

                                    </button>
                                </td>

                                <td>
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data penjualan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showDetail(data) {

            function formatProduk(text) {
                let words = text.split(' ');
                let result = '';

                words.forEach((word, index) => {
                    if (index > 0 && index % 9 === 0) {
                        result += '<br>';
                    }
                    result += word + ' ';
                });

                return result.trim();
            }

            let productRows = '';

            data.details.forEach((d) => {
                productRows += `
                <tr>
                    <td style="text-align:left; padding:8px;">
                        ${formatProduk(d.produk)}
                    </td>
                    <td style="text-align:center; font-size:11px;">${d.qty}</td>
                    <td style="text-align:right; font-size:11px;">${d.harga}</td>
                    <td style="text-align:right; font-size:11px; color:#198754; font-weight:600;">
                        ${d.subtotal}
                    </td>
                </tr>
                `;
            });

            Swal.fire({
                title: 'Detail Penjualan',
                width: '900px',
                html: `
                <div style="text-align:left; margin-bottom:15px; font-size:14px;">
                    <div style="background:#f8f9fa; padding:12px; border-radius:10px; border:1px solid #eee;">
                        <table style="font-size:13px;">
                            <tr>
                                <td style="width:90px;"><b>Tanggal</b></td>
                                <td style="width:10px;">:</td>
                                <td>${data.tanggal}</td>
                            </tr>
                            <tr>
                                <td><b>Customer</b></td>
                                <td>:</td>
                                <td>${data.customer}</td>
                            </tr>
                            <tr>
                                <td><b>Resi</b></td>
                                <td>:</td>
                                <td>${data.resi}</td>
                            </tr>
                            <tr>
                                <td><b>Total</b></td>
                                <td>:</td>
                                <td style="color:#198754; font-weight:600;">
                                    ${data.total}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:12px;">
                        <thead>
                            <tr style="background:#f1f3f5;">
                                <th style="text-align:left; padding:8px;">Produk</th>
                                <th style="padding:8px;">Qty</th>
                                <th style="padding:8px;">Harga</th>
                                <th style="padding:8px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${productRows}
                        </tbody>
                    </table>
                </div>
                `,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#198754'
            });
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data penjualan akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    title: 'swal-title-sm',
                    htmlContainer: 'swal-text-sm',
                    confirmButton: 'swal-btn-sm',
                    cancelButton: 'swal-btn-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        let timeout = null;

        document.getElementById('search').addEventListener('keyup', function() {

            clearTimeout(timeout);

            timeout = setTimeout(() => {

                let query = this.value;

                fetch(`{{ route('sales.search') }}?q=${query}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('salesTable').innerHTML = html;
                    });

            }, 300);

        });
    </script>
@endsection
