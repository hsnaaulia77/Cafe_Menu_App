@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4" x-data="{ showTambah: false }">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Form Meja (table)</h3>
        <a href="{{ route('tables.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Cari meja..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <div class="mb-3 text-muted">Untuk mendata meja-meja yang tersedia di cafe.</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header bg-light border-bottom">
            <strong>Tabel Meja</strong>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th class="py-3 px-3 text-center">#</th>
                        <th class="py-3 px-3 text-center">NOMOR MEJA</th>
                        <th class="py-3 px-3 text-center">KAPASITAS</th>
                        <th class="py-3 px-3 text-center">STATUS</th>
                        <th class="py-3 px-3 text-center">LOKASI</th>
                        <th class="py-3 px-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tables as $table)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($tables->currentPage()-1)*$tables->perPage() }}</td>
                        <td class="text-center">{{ $table->number }}</td>
                        <td class="text-center">{{ $table->kapasitas }}</td>
                        <td class="text-center">
                            <span class="badge {{ $table->status == 'tersedia' ? 'bg-success' : ($table->status == 'digunakan' ? 'bg-warning' : 'bg-secondary') }}">
                                {{ $table->status == 'tersedia' ? 'Tersedia' : ($table->status == 'digunakan' ? 'Digunakan' : 'Tidak Tersedia') }}
                            </span>
                        </td>
                        <td class="text-center">{{ $table->lokasi ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $table->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $table->id }}" title="Hapus">
                                <i class="fas fa-trash"></i>
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
<x-admin-modal title="Tambah Meja">
            <form method="POST" action="{{ route('tables.store') }}">
                @csrf
        <label for="number">Nomor Meja</label>
        <input type="number" id="number" name="number" required>
        <label for="kapasitas">Kapasitas</label>
        <input type="number" id="kapasitas" name="kapasitas" required>
        <label for="status">Status</label>
        <select id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="digunakan">Digunakan</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                        </select>
        <label for="lokasi">Lokasi <span style="color:#e0b873;font-size:0.95em;">(opsional)</span></label>
        <input type="text" id="lokasi" name="lokasi">
        <button type="submit" class="btn-simpan">Simpan</button>
            </form>
</x-admin-modal>
@endsection
