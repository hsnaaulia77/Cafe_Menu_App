@extends('layouts.app')
@section('content')
<div class="container mt-4 d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="card p-4 shadow-lg" style="max-width:420px;width:100%;background:rgba(30,30,35,0.98);border-radius:1.3rem;">
        <h3 class="mb-4 text-center" style="color:#ffd700;font-family:Montserrat,sans-serif;font-weight:700;">Tambah Meja</h3>
        <form method="POST" action="{{ route('tables.store') }}">
            @csrf
            <label for="number" style="color:#ffd700;font-weight:600;">Nomor Meja</label>
            <input type="number" id="number" name="number" class="form-control mb-3" required>
            <label for="kapasitas" style="color:#ffd700;font-weight:600;">Kapasitas</label>
            <input type="number" id="kapasitas" name="kapasitas" class="form-control mb-3" required>
            <label for="status" style="color:#ffd700;font-weight:600;">Status</label>
            <select id="status" name="status" class="form-control mb-3" required>
                <option value="tersedia">Tersedia</option>
                <option value="digunakan">Digunakan</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
            </select>
            <label for="lokasi" style="color:#ffd700;font-weight:600;">Lokasi <span style="color:#e0b873;font-size:0.95em;">(opsional)</span></label>
            <input type="text" id="lokasi" name="lokasi" class="form-control mb-4">
            <button type="submit" class="btn btn-cafe w-100" style="background:linear-gradient(90deg,#ffd700 0%,#b87333 100%);color:#18181c;font-weight:700;border-radius:0.9rem;font-size:1.13rem;">Simpan</button>
        </form>
    </div>
</div>
@endsection 