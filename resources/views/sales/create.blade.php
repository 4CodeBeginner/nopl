@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 12px;
            border: none;
        }
    </style>

    <div class="container">

        <h4 class="mb-4">Tambah Penjualan</h4>

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Resi</label>
                        <input type="text" name="tracking_number" class="form-control">
                    </div>

                    <hr>

                    <h5>Produk</h5>

                    <div id="wrapper">
                        <div class="row mb-2 item">
                            <div class="col">
                                <select name="products[]" class="form-control">
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name_product }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <input type="number" name="qty[]" class="form-control" placeholder="Qty">
                            </div>

                            <div class="col">
                                <input type="number" name="price[]" class="form-control" placeholder="Harga">
                            </div>

                            <div class="col-auto">
                                <button type="button" class="btn btn-danger" onclick="removeRow(this)">🗑</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">
                        + Tambah Produk
                    </button>

                    <br>

                    <button class="btn btn-success">Simpan</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </div>

    <script>
        function addRow() {
            let html = `
    <div class="row mb-2 item">
        <div class="col">
            <select name="products[]" class="form-control">
                @foreach ($products as $p)
                <option value="{{ $p->id }}">{{ $p->name_product }}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <input type="number" name="qty[]" class="form-control" placeholder="Qty">
        </div>

        <div class="col">
            <input type="number" name="price[]" class="form-control" placeholder="Harga">
        </div>

        <div class="col-auto">
            <button type="button" class="btn btn-danger" onclick="removeRow(this)">🗑</button>
        </div>
    </div>
    `;
            document.getElementById('wrapper').insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            const items = document.querySelectorAll('.item');
            if (items.length <= 1) {
                alert('Minimal 1 produk');
                return;
            }
            btn.closest('.item').remove();
        }
    </script>
@endsection
