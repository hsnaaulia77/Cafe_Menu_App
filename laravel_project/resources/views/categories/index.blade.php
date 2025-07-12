@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4" x-data="{ showTambah: false }">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Menu Kategori</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header bg-light border-bottom">
            <strong>Tabel Kategori</strong>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th class="py-3 px-3 text-center">#</th>
                        <th class="py-3 px-3 text-start">NAMA</th>
                        <th class="py-3 px-3 text-start">SLUG</th>
                        <th class="py-3 px-3 text-start">DESKRIPSI</th>
                        <th class="py-3 px-3 text-center">STATUS</th>
                        <th class="py-3 px-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
                        <td class="text-start">{{ $category->name }}</td>
                        <td class="text-start">{{ $category->slug }}</td>
                        <td class="text-start">{{ $category->description }}</td>
                        <td class="text-center">
                            <span class="badge {{ $category->status == 'tersedia' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->status == 'tersedia' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $category->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="editDataModal{{ $category->id }}" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('categories.update', $category->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="editName{{ $category->id }}" class="form-label">Nama Kategori</label>
                                            <input type="text" class="form-control" id="editName{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editSlug{{ $category->id }}" class="form-label">Slug</label>
                                            <input type="text" class="form-control" id="editSlug{{ $category->id }}" name="slug" value="{{ $category->slug }}" required readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editDescription{{ $category->id }}" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="editDescription{{ $category->id }}" name="description">{{ $category->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editStatus{{ $category->id }}" class="form-label">Status</label>
                                            <select class="form-control" id="editStatus{{ $category->id }}" name="status" required>
                                                <option value="tersedia" {{ $category->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="tidak tersedia" {{ $category->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus Data -->
                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus kategori <b>{{ $category->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<x-admin-modal title="Tambah Kategori">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
        <label for="name">Nama Kategori</label>
        <input type="text" id="name" name="name" required>
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" required readonly>
        <label for="icon">Icon (FontAwesome, contoh: fa-coffee)</label>
        <input type="text" id="icon" name="icon" placeholder="fa-coffee" required>
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description"></textarea>
        <label for="status">Status</label>
        <select id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                        </select>
        <button type="submit" class="btn-simpan">Simpan</button>
            </form>
</x-admin-modal>
@endsection

@push('scripts')
<script>
    function string_to_slug(str) {
        return str
            .toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Tambah Kategori
        var nameInput = document.getElementById('name');
        var slugInput = document.getElementById('slug');
        if(nameInput && slugInput) {
            nameInput.addEventListener('input', function() {
                slugInput.value = string_to_slug(this.value);
            });
        }

        // Edit Kategori (jika ingin otomatis juga di edit)
        @foreach($categories as $category)
            var editName = document.getElementById('editName{{ $category->id }}');
            var editSlug = document.getElementById('editSlug{{ $category->id }}');
            if(editName && editSlug) {
                editName.addEventListener('input', function() {
                    editSlug.value = string_to_slug(this.value);
                });
            }
        @endforeach
    });
</script>
@endpush
