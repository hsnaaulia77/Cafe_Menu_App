@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Menu</h2>
    <a href="{{ route('menus.create') }}" class="btn btn-success mb-3">Tambah Menu</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->nama }}</td>
                <td>{{ $menu->kategori }}</td>
                <td>Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td>{{ $menu->status }}</td>
                <td>
                    @if($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" width="50">
                    @endif
                </td>
                <td>
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
