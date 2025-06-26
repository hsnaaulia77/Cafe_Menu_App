@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Form Meja (table)</h3>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDataModal">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>
    <div class="mb-3 text-muted">Untuk mendata meja-meja yang tersedia di cafe.</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <strong>Tabel Meja</strong>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NOMOR MEJA</th>
                        <th>KAPASITAS</th>
                        <th>STATUS</th>
                        <th>LOKASI</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tables as $table)
                    <tr>
                        <td>{{ $loop->iteration + ($tables->currentPage()-1)*$tables->perPage() }}</td>
                        <td>{{ $table->number }}</td>
                        <td>{{ $table->kapasitas }}</td>
                        <td>
                            <span class="badge {{ $table->status == 'tersedia' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($table->status) }}
                            </span>
                        </td>
                        <td>{{ $table->lokasi ?? '-' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $table->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $table->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="editDataModal{{ $table->id }}" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('tables.update', $table->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Meja</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="editNumber{{ $table->id }}" class="form-label">Nomor Meja</label>
                                            <input type="number" class="form-control" id="editNumber{{ $table->id }}" name="number" value="{{ $table->number }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKapasitas{{ $table->id }}" class="form-label">Kapasitas</label>
                                            <input type="number" class="form-control" id="editKapasitas{{ $table->id }}" name="kapasitas" value="{{ $table->kapasitas }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editStatus{{ $table->id }}" class="form-label">Status</label>
                                            <select class="form-control" id="editStatus{{ $table->id }}" name="status" required>
                                                <option value="tersedia" {{ $table->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="digunakan" {{ $table->status == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                                                <option value="tidak tersedia" {{ $table->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editLokasi{{ $table->id }}" class="form-label">Lokasi <span class="text-muted">(opsional)</span></label>
                                            <input type="text" class="form-control" id="editLokasi{{ $table->id }}" name="lokasi" value="{{ $table->lokasi }}">
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
                    <div class="modal fade" id="deleteModal{{ $table->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('tables.destroy', $table->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus meja nomor <b>{{ $table->number }}</b>?
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
                {{ $tables->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('tables.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="number" class="form-label">Nomor Meja</label>
                        <input type="number" class="form-control" id="number" name="number" required>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="digunakan">Digunakan</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi <span class="text-muted">(opsional)</span></label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi">
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
