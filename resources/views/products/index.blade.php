<!DOCTYPE html>
<html>

<head>
    <title>Data Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @extends('layouts.app')

    @section('content')

        <style>
            .card {
                border-radius: 12px;
                border: none;
            }

            .table th,
            .table td {
                text-align: center;
                vertical-align: middle;
            }

            .name-ellipsis {
                max-width: 180px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .price-wrap {
                display: flex;
                justify-content: center;
                gap: 6px;
            }

            .currency {
                width: 25px;
                text-align: right;
                font-weight: 600;
            }

            .amount {
                min-width: 90px;
                text-align: left;
                font-family: monospace;
                font-weight: 600;
            }

            .qty-badge {
                display: inline-block;
                min-width: 45px;
                text-align: center;
                font-weight: 600;
                padding: 5px 10px;
                border-radius: 8px;
            }

            .btn-sm {
                border-radius: 8px;
            }

            .carousel-wrapper {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 12px;
                text-align: center;
            }

            .modal-img {
                max-height: 220px;
                width: 100%;
                object-fit: contain;
                border-radius: 10px;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 38px;
                height: 38px;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.25);
                border-radius: 50%;
                transition: 0.2s;
            }

            .carousel-control-prev:hover,
            .carousel-control-next:hover {
                background: rgba(0, 0, 0, 0.55);
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                width: 16px;
                height: 16px;
            }

            .desc-box {
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                overflow-y: auto;
                line-height: 1.5;
                max-height: calc(1.5em * 4);
                padding-right: 6px;
            }

            .desc-box::-webkit-scrollbar {
                width: 5px;
            }

            .desc-box::-webkit-scrollbar-thumb {
                background: #bbb;
                border-radius: 10px;
            }

            .swal-title-sm {
                font-size: 22px !important;
            }

            .swal-text-sm {
                font-size: 15px !important;
            }

            .swal-btn-sm {
                font-size: 14px !important;
                padding: 8px 18px !important;
                border-radius: 8px !important;
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
                                <th>Qty</th>
                                <th>Harga</th>
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

                                    <td class="fw-semibold name-ellipsis" title="{{ $product->name_product }}">
                                        {{ $product->name_product }}
                                    </td>

                                    <td>
                                        <span
                                            class="badge qty-badge
                                            {{ $product->qty == 0 ? 'bg-danger' : ($product->qty < 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                                            {{ $product->qty }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="price-wrap">
                                            <span class="currency">Rp</span>
                                            <span class="amount">
                                                {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ $product->link }}" target="_blank"
                                                class="btn btn-sm btn-info text-white shadow-sm">
                                                Lihat
                                            </a>
                                        </div>
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

                                            <button type="button" class="btn btn-sm btn-danger shadow-sm"
                                                onclick="confirmDelete(this)">
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
                                                <div class="mt-3">

                                                    <p><strong>ID Product:</strong><br>
                                                        {{ $product->id_product }}
                                                    </p>

                                                    <p><strong>Nama:</strong><br>
                                                        {{ $product->name_product }}
                                                    </p>

                                                    <p><strong>Brand:</strong><br>
                                                        {{ strtoupper($product->brand) }}
                                                    </p>

                                                    <p><strong>Quantity:</strong><br>
                                                        {{ $product->qty }}
                                                    </p>

                                                    <p><strong>Harga:</strong><br>
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </p>

                                                    <p><strong>Link:</strong><br>
                                                        <a href="{{ $product->link }}" target="_blank">
                                                            {{ $product->link }}
                                                        </a>
                                                    </p>

                                                    <p class="mb-1"><strong>Deskripsi:</strong></p>
                                                    <div class="desc-box">
                                                        {!! nl2br(e($product->description)) !!}
                                                    </div>

                                                </div>

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

    <script>
        function confirmDelete(button) {

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Produk akan dipindahkan ke data terhapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
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
    </script>

    </body>

</html>
