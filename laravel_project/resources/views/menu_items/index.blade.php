@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Menu Item</h3>
        <a href="{{ route('menu_items.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Menu
        </a>
    </div>
    <form method="GET" action="" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header bg-light border-bottom"><strong>Tabel Menu Item</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th class="py-3 px-3 text-center">#</th>
                        <th class="py-3 px-3 text-start">Nama Menu</th>
                        <th class="py-3 px-3 text-start">Kategori</th>
                        <th class="py-3 px-3 text-end">Harga</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center">Stok</th>
                        <th class="py-3 px-3 text-center">Gambar</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuItems as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($menuItems->currentPage()-1)*$menuItems->perPage() }}</td>
                        <td class="text-start">{{ $item->nama }}</td>
                        <td class="text-start">{{ $item->kategori->name ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($item->harga,0,',','.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->stok ?? '-' }}</td>
                        <td class="text-center">
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="Gambar" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('menu_items.edit', $item->id) }}" class="btn btn-warning btn-sm me-2" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('menu_items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')" title="Hapus"><i class="fas fa-trash"></i></button>
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