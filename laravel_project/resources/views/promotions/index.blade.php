@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Daftar Promosi</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Promosi</span>
            <a href="{{ route('promotions.create') }}" class="btn btn-primary">Tambah Promosi</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Promo</th>
                            <th>Deskripsi</th>
                            <th>Kode Voucher</th>
                            <th>Diskon (%)</th>
                            <th>Potongan Harga</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $promo)
                        <tr>
                            <td>{{ $loop->iteration + ($promotions->currentPage() - 1) * $promotions->perPage() }}</td>
                            <td>{{ $promo->nama }}</td>
                            <td>{{ $promo->deskripsi }}</td>
                            <td>{{ $promo->kode_voucher ?? '-' }}</td>
                            <td>{{ $promo->diskon_persen ?? '-' }}</td>
                            <td>{{ $promo->potongan_harga ? 'Rp '.number_format($promo->potongan_harga) : '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $promo->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($promo->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('promotions.edit', $promo) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('promotions.destroy', $promo) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus promosi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
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