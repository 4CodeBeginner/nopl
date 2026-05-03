<!DOCTYPE html>
<html>

<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>

<script>
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("photo-input")) {

            const wrapper = document.getElementById('photo-wrapper');
            const inputs = wrapper.querySelectorAll('.photo-input');

            const allFilled = Array.from(inputs).every(input => input.value !== '');

            if (allFilled && inputs.length < 3) {
                addInput();
            }
        }
    });

    function addInput() {
        const wrapper = document.getElementById('photo-wrapper');
        const total = wrapper.querySelectorAll('.photo-input').length;

        if (total >= 3) return;

        const div = document.createElement("div");
        div.classList.add("input-group", "mb-2");

        div.innerHTML = `
            <input type="file" name="photos[]" class="form-control photo-input" accept="image/*">
            <button type="button" class="btn btn-danger" onclick="removeInput(this)">🗑</button>
        `;

        wrapper.appendChild(div);
    }

    function removeInput(button) {
        const wrapper = document.getElementById('photo-wrapper');
        const inputs = wrapper.querySelectorAll('.input-group');

        if (inputs.length <= 1) {
            alert("Minimal 1 foto");
            return;
        }

        button.parentElement.remove();
    }
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
                        <input type="file" name="photos[]" class="form-control photo-input" accept="image/*"
                            required>
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
