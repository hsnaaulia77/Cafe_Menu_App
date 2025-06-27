@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Menu Review</h3>
        <a href="{{ route('reviews.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Review
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
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Tabel Review</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="py-3 px-3 text-center">#</th>
                            <th class="py-3 px-3 text-start">Nama Customer</th>
                            <th class="py-3 px-3 text-start">Menu</th>
                            <th class="py-3 px-3 text-center">Rating</th>
                            <th class="py-3 px-3 text-start">Komentar</th>
                            <th class="py-3 px-3 text-center">Tanggal</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}</td>
                            <td class="text-start">{{ $review->nama_customer ?? 'Anonim' }}</td>
                            <td class="text-start">{{ $review->menuItem->nama ?? '-' }}</td>
                            <td class="text-center">{{ $review->rating }}</td>
                            <td class="text-start">{{ $review->komentar }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($review->tanggal)->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus review ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada review.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection 