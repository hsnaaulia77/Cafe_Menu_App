@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Menu Kategori</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDataModal">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <strong>Tabel Kategori</strong>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMA</th>
                        <th>SLUG</th>
                        <th>DESKRIPSI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <span class="badge {{ $category->status == 'tersedia' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $category->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                                <i class="fas fa-trash"></i> Hapus
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
<div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
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
