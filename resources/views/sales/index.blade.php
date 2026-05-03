@extends('layouts.app')

@section('content')

<style>
    .card {
        border-radius: 12px;
        border: none;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-sm {
        border-radius: 8px;
    }
</style>

<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm">
        + Tambah Penjualan
    </a>
</div>

@if(session('success'))
<div class="alert alert-success shadow-sm">
    {{ session('success') }}
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th width="200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($sales as $i => $sale)
                    <tr>
                        <td class="text-center fw-semibold">{{ $i+1 }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td class="fw-semibold">Rp {{ number_format($sale->total_amount) }}</td>

                        <td class="text-center">

                            <!-- DETAIL MODAL BUTTON -->
                            <button class="btn btn-sm btn-info text-white shadow-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $sale->id }}">
                                Detail
                            </button>

                            <!-- DELETE -->
                            <form action="{{ route('sales.destroy',$sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus data?')"
                                    class="btn btn-sm btn-danger shadow-sm">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>

                    <!-- MODAL DETAIL -->
                    <div class="modal fade" id="detailModal{{ $sale->id }}">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Detail Penjualan
                                    </h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <p><strong>Customer:</strong> {{ $sale->customer_name }}</p>
                                    <p><strong>Tanggal:</strong> {{ $sale->sale_date }}</p>
                                    <p><strong>Total:</strong> Rp {{ number_format($sale->total_amount) }}</p>

                                    <hr>

                                    <table class="table table-bordered">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sale->details as $d)
                                            <tr>
                                                <td>{{ $d->product->name_product }}</td>
                                                <td class="text-center">{{ $d->quantity }}</td>
                                                <td>Rp {{ number_format($d->price) }}</td>
                                                <td>Rp {{ number_format($d->subtotal) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada data penjualan
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
