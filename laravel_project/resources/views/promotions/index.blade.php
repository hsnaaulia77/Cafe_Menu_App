@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Promosi</h3>
        <a href="{{ route('promotions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Promosi
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Cari order..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header bg-light border-bottom">
            <strong>Tabel Promosi</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="py-3 px-3 text-center">#</th>
                            <th class="py-3 px-3 text-start">Nama Promo</th>
                            <th class="py-3 px-3 text-start">Deskripsi</th>
                            <th class="py-3 px-3 text-center">Kode Voucher</th>
                            <th class="py-3 px-3 text-center">Diskon (%)</th>
                            <th class="py-3 px-3 text-end">Potongan Harga</th>
                            <th class="py-3 px-3 text-center">Tanggal Mulai</th>
                            <th class="py-3 px-3 text-center">Tanggal Berakhir</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promo)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($promotions->currentPage() - 1) * $promotions->perPage() }}</td>
                            <td class="text-start">{{ $promo->nama }}</td>
                            <td class="text-start">{{ $promo->deskripsi }}</td>
                            <td class="text-center">{{ $promo->kode_voucher ?? '-' }}</td>
                            <td class="text-center">{{ $promo->diskon_persen ?? '-' }}</td>
                            <td class="text-end">{{ $promo->potongan_harga ? 'Rp '.number_format($promo->potongan_harga) : '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $promo->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($promo->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('promotions.edit', $promo) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('promotions.destroy', $promo) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus promosi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada promosi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $promotions->links() }}
        </div>
    </div>
</div>
@endsection 