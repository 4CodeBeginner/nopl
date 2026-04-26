<!DOCTYPE html>
<html>

<head>
    <title>Data Produk</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Produk</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>ID Product</th>
                            <th>Nama</th>
                            <th>Brand</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Link</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $product->id_product }}</td>
                                <td>{{ $product->name_product }}</td>
                                <td>{{ strtoupper($product->brand) }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @php
                                            $photos = explode(',', $product->photo);
                                        @endphp

                                        @foreach (array_slice($photos, 0, 2) as $img)
                                            <img src="{{ asset($img) }}"
                                                style="width:60px; height:60px; object-fit:cover;"
                                                class="rounded border">
                                        @endforeach

                                        @if (count($photos) > 2)
                                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded"
                                                style="width:60px; height:60px;">
                                                +{{ count($photos) - 2 }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ $product->link }}" target="_blank" class="btn btn-sm btn-info">
                                        Lihat
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data produk belum ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</body>

</html>
