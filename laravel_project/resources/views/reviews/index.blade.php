@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Menu Review</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Tabel Review</span>
            <a href="{{ route('reviews.create') }}" class="btn btn-primary">Tambah Review</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Customer</th>
                            <th>Menu</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}</td>
                            <td>{{ $review->nama_customer ?? 'Anonim' }}</td>
                            <td>{{ $review->menuItem->nama ?? '-' }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->komentar }}</td>
                            <td>{{ \Carbon\Carbon::parse($review->tanggal)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus review ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
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