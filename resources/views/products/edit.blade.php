<<<<<<< HEAD
@extends('layouts.app')

@section('content')

    <style>
        .card {
            border-radius: 12px;
            border: none;
        }

        .img-preview {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .img-box {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .btn-delete-img {
            position: absolute;
            top: -8px;
            right: -8px;
            background: red;
            color: white;
            border-radius: 50%;
            border: none;
            width: 22px;
            height: 22px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>

    <div class="container">

        <h4 class="mb-4">Edit Produk</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">ID Product</label>
                        <input type="text" class="form-control" value="{{ $product->id_product }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name_product" class="form-control" value="{{ $product->name_product }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select name="brand" class="form-select" required>
                            <option value="hotw" {{ $product->brand == 'hotw' ? 'selected' : '' }}>Hot Wheels</option>
                            <option value="minigt" {{ $product->brand == 'minigt' ? 'selected' : '' }}>Mini GT</option>
                            <option value="poprace" {{ $product->brand == 'poprace' ? 'selected' : '' }}>Pop Race</option>
                            <option value="tomica" {{ $product->brand == 'tomica' ? 'selected' : '' }}>Tomica</option>
                            <option value="mbx" {{ $product->brand == 'mbx' ? 'selected' : '' }}>Matchbox</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" name="link" class="form-control" value="{{ $product->link }}" required>
                    </div>

                    <!-- FOTO LAMA -->
                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini</label><br>

                        @php
                            $photos = explode(',', $product->photo);
                        @endphp

                        <div id="old-photo-wrapper">
                            @foreach ($photos as $img)
                                <div class="img-box">
                                    <img src="{{ asset($img) }}" class="img-preview">
                                    <input type="hidden" name="old_photos[]" value="{{ $img }}">
                                    <button type="button" class="btn-delete-img" onclick="removeOldImage(this)">🗑</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tambah Foto (min 1, max 3)</label>

                        <div id="photo-wrapper">
                            <div class="input-group mb-2">
                                <input type="file" name="photos[]" class="form-control photo-input" accept="image/*">
                                <button type="button" class="btn btn-danger" onclick="removeInput(this)">🗑</button>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-1">
                            Maksimal 3 foto
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </div>

    <script>
        function getOldCount() {
            return document.querySelectorAll('#old-photo-wrapper input').length;
        }

        function getNewFilledCount() {
            return Array.from(document.querySelectorAll('.photo-input'))
                .filter(input => input.value !== '').length;
        }

        function getTotal() {
            return getOldCount() + getNewFilledCount();
        }

        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("photo-input")) {

                const inputs = document.querySelectorAll('.photo-input');
                const allFilled = Array.from(inputs).every(input => input.value !== '');

                if (allFilled && getTotal() < 3) {
                    addInput();
                }
            }
        });

        function addInput() {
            if (getTotal() >= 3) return;

            const wrapper = document.getElementById('photo-wrapper');

            const div = document.createElement("div");
            div.classList.add("input-group", "mb-2");

            div.innerHTML = `
            <input type="file" name="photos[]" class="form-control photo-input" accept="image/*">
            <button type="button" class="btn btn-danger" onclick="removeInput(this)">🗑</button>
        `;

            wrapper.appendChild(div);
        }

        function removeInput(button) {
            if (getTotal() <= 1) {
                alert("Minimal 1 foto");
                return;
            }

            button.parentElement.remove();
        }

        function removeOldImage(btn) {
            if (getTotal() <= 1) {
                alert("Minimal 1 foto");
                return;
            }

            btn.parentElement.remove();
        }

        document.addEventListener("change", function(e) {
            if (e.target.classList.contains("photo-input")) {

                if (getTotal() > 3) {
                    e.target.value = "";
                    alert("Maksimal 3 foto");
                    return;
                }

                const inputs = document.querySelectorAll('.photo-input');
                const allFilled = Array.from(inputs).every(input => input.value !== '');

                if (allFilled && getTotal() < 3) {
                    addInput();
                }
            }
        });
    </script>

@endsection
=======
>>>>>>> 405d6a141283845c111649c68d94e2087a0b4e4e
