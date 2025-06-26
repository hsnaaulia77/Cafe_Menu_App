@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Menu Item</h3>
        <a href="{{ route('menu_items.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Menu
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header"><strong>Tabel Menu Item</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuItems as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($menuItems->currentPage()-1)*$menuItems->perPage() }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga,0,',','.') }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->stok ?? '-' }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="Gambar" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('menu_items.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('menu_items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data menu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $menuItems->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 