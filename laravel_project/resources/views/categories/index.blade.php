@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Menu Categori</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah</button>
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
                        <th>CREATED AT</th>
                        <th>UPDATED AT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at->format('d F Y H:i') }}</td>
                        <td>{{ $category->updated_at->format('d F Y H:i') }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $category->id }}">Edit</button>
                            <!-- Delete Button -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
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
                                            <label for="editName{{ $category->id }}" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="editName{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus kategori <b>{{ $category->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Data</td>
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
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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
