@extends('layouts.app')
@section('content')
<div class="container mt-4 d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="card p-4 shadow-lg" style="max-width:420px;width:100%;background:rgba(30,30,35,0.98);border-radius:1.3rem;">
        <h3 class="mb-4 text-center" style="color:#ffd700;font-family:Montserrat,sans-serif;font-weight:700;">Tambah Kategori</h3>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <label for="name" style="color:#ffd700;font-weight:600;">Nama Kategori</label>
            <input type="text" id="name" name="name" class="form-control mb-3" required oninput="generateSlug()">
            <label for="slug" style="color:#ffd700;font-weight:600;">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control mb-3" required readonly>
            <label for="description" style="color:#ffd700;font-weight:600;">Deskripsi</label>
            <textarea id="description" name="description" class="form-control mb-3" placeholder="Deskripsi kategori"></textarea>
            <label for="status" style="color:#ffd700;font-weight:600;">Status</label>
            <select id="status" name="status" class="form-control mb-4" required>
                <option value="tersedia">Tersedia</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
            </select>
            <button type="submit" class="btn btn-cafe w-100" style="background:linear-gradient(90deg,#ffd700 0%,#b87333 100%);color:#18181c;font-weight:700;border-radius:0.9rem;font-size:1.13rem;">Simpan</button>
        </form>
    </div>
</div>
@endsection
<script>
function generateSlug() {
    const name = document.getElementById('name').value;
    let slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('slug').value = slug;
}
</script> 