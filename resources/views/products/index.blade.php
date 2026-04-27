<!DOCTYPE html>
<html>

<head>
    <title>Data Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

            /* WRAPPER FOTO */
            .carousel-wrapper {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 10px;
                text-align: center;
            }

            /* GAMBAR FIX (ANTI STRETCH) */
            .modal-img {
                max-height: 220px;
                width: 100%;
                object-fit: contain;
                border-radius: 10px;
            }

            /* CONTROL PANAH */
            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.3);
                border-radius: 50%;
            }

            .carousel-control-prev:hover,
            .carousel-control-next:hover {
                background: rgba(0, 0, 0, 0.6);
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                width: 18px;
                height: 18px;
            }
        </style>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
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
                                <th>ID Product</th>
                                <th>Nama</th>
                                <th>Brand</th>
                                <th>Link</th>
                                <th width="220px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>

                                    <td class="text-nowrap">
                                        {{ $product->id_product }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $product->name_product }}
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-secondary text-uppercase">
                                            {{ $product->brand }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ $product->link }}" target="_blank"
                                            class="btn btn-sm btn-info text-white shadow-sm">
                                            Lihat
                                        </a>
                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $product->id }}">
                                            Detail
                                        </button>

                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning text-white shadow-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger shadow-sm"
                                                onclick="return confirm('Yakin hapus?')">
                                                Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                                <!-- MODAL DETAIL -->
                                <div class="modal fade" id="detailModal{{ $product->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    {{ $product->name_product }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                @php
                                                    $photos = explode(',', $product->photo);
                                                @endphp

                                                <!-- CAROUSEL -->
                                                <div class="carousel-wrapper mb-3">
                                                    <div id="carousel{{ $product->id }}" class="carousel slide">

                                                        <div class="carousel-inner">
                                                            @foreach ($photos as $key => $img)
                                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                    <img src="{{ asset($img) }}" class="modal-img">
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (count($photos) > 1)
                                                            <button class="carousel-control-prev" type="button"
                                                                data-bs-target="#carousel{{ $product->id }}"
                                                                data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"></span>
                                                            </button>

                                                            <button class="carousel-control-next" type="button"
                                                                data-bs-target="#carousel{{ $product->id }}"
                                                                data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"></span>
                                                            </button>
                                                        @endif

                                                    </div>
                                                </div>

                                                <!-- DETAIL -->
                                                <p><strong>ID:</strong> {{ $product->id_product }}</p>
                                                <p><strong>Brand:</strong> {{ strtoupper($product->brand) }}</p>

                                                <p class="mb-1"><strong>Deskripsi:</strong></p>
                                                <p class="text-muted">
                                                    {{ $product->description }}
                                                </p>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data produk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
