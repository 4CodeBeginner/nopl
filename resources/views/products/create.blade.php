@extends('layouts.app')

@section('content')

    <style>
        .card {
            border-radius: 14px;
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .photo-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
        }
    </style>

    <div class="container-fluid">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h4 class="fw-semibold mb-4">
                    Tambah Produk
                </h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ID PRODUCT -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            ID Product
                        </label>

                        <input type="text" class="form-control" value="Otomatis dibuat berdasarkan brand" disabled>
                    </div>

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Produk
                        </label>

                        <input type="text" name="name_product"
                            class="form-control @error('name_product') is-invalid @enderror"
                            value="{{ old('name_product') }}" required>

                        @error('name_product')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- BRAND -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Brand
                        </label>

                        <select name="brand" class="form-select @error('brand') is-invalid @enderror" required>

                            <option value="">Pilih Brand</option>

                            <option value="hotw" {{ old('brand') == 'hotw' ? 'selected' : '' }}>
                                Hot Wheels
                            </option>

                            <option value="minigt" {{ old('brand') == 'minigt' ? 'selected' : '' }}>
                                Mini GT
                            </option>

                            <option value="poprace" {{ old('brand') == 'poprace' ? 'selected' : '' }}>
                                Pop Race
                            </option>

                            <option value="tomica" {{ old('brand') == 'tomica' ? 'selected' : '' }}>
                                Tomica
                            </option>

                            <option value="mbx" {{ old('brand') == 'mbx' ? 'selected' : '' }}>
                                Matchbox
                            </option>

                        </select>

                        @error('brand')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- QTY -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Quantity
                        </label>

                        <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                            value="{{ old('qty') }}" min="0" required>

                        @error('qty')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- HARGA -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Harga
                        </label>

                        <input type="text" name="price" id="price"
                            class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>

                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>

                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- LINK -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Link Produk
                        </label>

                        <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                            value="{{ old('link') }}" required>

                        @error('link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- FOTO -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Upload Foto
                        </label>

                        <div class="photo-box">

                            <div id="photo-wrapper">

                                <div class="input-group mb-2">

                                    <input type="file" name="photos[]" class="form-control photo-input" accept="image/*"
                                        required>

                                    <button type="button" class="btn btn-danger" onclick="removeInput(this)">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            </div>

                            <small class="text-muted">
                                Minimal 1 foto dan maksimal 3 foto
                            </small>

                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-success px-4">
                            Simpan
                        </button>

                        <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

    <script>
        function getTotalInputs() {
            return document.querySelectorAll('.photo-input').length;
        }

        function getFilledInputs() {
            return Array.from(document.querySelectorAll('.photo-input'))
                .filter(input => input.value !== '').length;
        }

        document.addEventListener("change", function(e) {

            if (e.target.classList.contains("photo-input")) {

                if (getFilledInputs() === getTotalInputs() && getTotalInputs() < 3) {
                    addInput();
                }

            }

        });

        function addInput() {

            if (getTotalInputs() >= 3) return;

            const wrapper = document.getElementById('photo-wrapper');

            const div = document.createElement("div");

            div.classList.add("input-group", "mb-2");

            div.innerHTML = `
                <input type="file"
                    name="photos[]"
                    class="form-control photo-input"
                    accept="image/*">

                <button type="button"
                    class="btn btn-danger"
                    onclick="removeInput(this)">

                    <i class="bi bi-trash"></i>

                </button>
            `;

            wrapper.appendChild(div);
        }

        function removeInput(button) {

            const inputs = document.querySelectorAll('.input-group');

            if (inputs.length <= 1) {
                alert("Minimal 1 foto");
                return;
            }

            button.parentElement.remove();
        }

        const priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function() {

            let value = this.value.replace(/\D/g, '');

            if (value) {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }

        });
    </script>

@endsection
