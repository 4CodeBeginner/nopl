<!DOCTYPE html>
<html>

<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

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
            <input type="file" name="photos[]" class="form-control photo-input" accept="image/*" onclick="handleClick(this)">
            <button type="button" class="btn btn-danger" onclick="removeInput(this)">🗑</button>
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

    function handleClick(input) {
        if (getTotalInputs() >= 3 && input.value === '') {
            alert("Maksimal 3 foto");
            input.blur();
        }
    }

    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');

        if (value) {
            this.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            this.value = '';
        }
    });
</script>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">Tambah Produk</h2>

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

            <div class="mb-3">
                <label class="form-label">ID Product</label>
                <input type="text" class="form-control" value="Otomatis dibuat berdasarkan brand" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name_product" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Brand</label>
                <select name="brand" class="form-select" required>
                    <option value="">Pilih Brand</option>
                    <option value="hotw">Hot Wheels</option>
                    <option value="minigt">Mini GT</option>
                    <option value="poprace">Pop Race</option>
                    <option value="tomica">Tomica</option>
                    <option value="mbx">Matchbox</option>
                </select>
            </div>

            <!-- QTY -->
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="qty" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="text" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Link Produk</label>
                <input type="url" name="link" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Foto (min 1, max 3)</label>

                <div id="photo-wrapper">
                    <div class="input-group mb-2">
                        <input type="file" name="photos[]" class="form-control photo-input" accept="image/*" required
                            onclick="handleClick(this)">
                        <button type="button" class="btn btn-danger" onclick="removeInput(this)">🗑</button>
                    </div>
                </div>

                <small class="text-muted d-block mt-1">
                    Maksimal 3 foto
                </small>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</body>

</html>
