@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 14px;
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table thead th {
            background-color: #212529;
            color: #fff;
        }

        .btn-sm {
            border-radius: 8px;
        }

        .total-box {
            font-size: 16px;
            font-weight: 600;
            color: #198754;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold">Tambah Penjualan</h4>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary shadow-sm">
            ← Kembali
        </a>
    </div>

    {{-- ERROR BACKEND --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Resi</label>
                        <input type="text" name="tracking_number" class="form-control" required>
                    </div>

                </div>

            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h6 class="fw-semibold">Detail Pembelian</h6>

                    <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
                        + Tambah Produk
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="productTable">

                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th width="120">Qty</th>
                                <th width="180">Harga</th>
                                <th width="180">Subtotal</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <select name="product_id[]" class="form-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->price }}">
                                                {{ $p->name_product }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control qty" value="1"
                                        min="1">
                                </td>
                                <td class="price">Rp 0</td>
                                <td class="subtotal">Rp 0</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">
                                        ×
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <div class="text-end mt-3">
                    <span>Total: </span>
                    <span class="total-box" id="grandTotal">Rp 0</span>
                </div>

                <input type="hidden" name="total_amount" id="totalInput">

            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">
                Simpan Penjualan
            </button>
        </div>

    </form>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function updateRow(row) {
            let select = row.querySelector('select');
            let qty = parseInt(row.querySelector('.qty').value) || 0;

            let price = select.options[select.selectedIndex]?.dataset.price || 0;
            price = parseInt(price);

            let subtotal = price * qty;

            row.querySelector('.price').innerText = formatRupiah(price);
            row.querySelector('.subtotal').innerText = formatRupiah(subtotal);

            updateTotal();
        }

        function updateTotal() {
            let total = 0;

            document.querySelectorAll('.subtotal').forEach(el => {
                let angka = el.innerText.replace(/[^\d]/g, '');
                total += parseInt(angka || 0);
            });

            document.getElementById('grandTotal').innerText = formatRupiah(total);
            document.getElementById('totalInput').value = total;
        }

        function addRow() {
            let table = document.querySelector('#productTable tbody');
            let row = table.rows[0].cloneNode(true);

            row.querySelector('select').value = '';
            row.querySelector('.qty').value = 1;
            row.querySelector('.price').innerText = 'Rp 0';
            row.querySelector('.subtotal').innerText = 'Rp 0';

            table.appendChild(row);
        }

        function removeRow(btn) {
            let row = btn.closest('tr');
            let table = document.querySelector('#productTable tbody');

            if (table.rows.length > 1) {
                row.remove();
                updateTotal();
            }
        }

        // EVENT
        document.addEventListener('change', function(e) {
            if (e.target.matches('select')) {
                updateRow(e.target.closest('tr'));
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.matches('.qty')) {
                updateRow(e.target.closest('tr'));
            }
        });

        // VALIDASI FRONTEND
        document.querySelector('form').addEventListener('submit', function(e) {

            let valid = true;
            let message = '';

            document.querySelectorAll('#productTable tbody tr').forEach(row => {

                let select = row.querySelector('select').value;
                let qty = row.querySelector('.qty').value;

                if (!select) {
                    valid = false;
                    message = 'Produk harus dipilih';
                }

                if (qty <= 0) {
                    valid = false;
                    message = 'Qty harus lebih dari 0';
                }

            });

            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi gagal',
                    text: message
                });
            }

        });
    </script>
@endsection
