@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Kelola Menu untuk Promosi: <b>{{ $promotion->nama }}</b></h3>
    <form method="POST" action="{{ route('promotions.updateMenus', $promotion->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="menu_item_ids" class="form-label">Pilih Menu:</label>
            <select name="menu_item_ids[]" id="menu_item_ids" class="form-control select2" multiple>
                @foreach($allMenus as $menu)
                    <option value="{{ $menu->id }}" {{ $promotion->menuItems->contains($menu->id) ? 'selected' : '' }}>
                        {{ $menu->nama }}
                    </option>
                @endforeach
            </select>
            @error('menu_item_ids')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('menu_item_ids.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Menu yang Sudah Dipilih:</label>
            <div>
                @forelse($promotion->menuItems as $menu)
                    <span class="badge bg-primary me-1 mb-1">{{ $menu->nama }}</span>
                @empty
                    <span class="text-muted">Belum ada menu dipilih.</span>
                @endforelse
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Menu</button>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#menu_item_ids').select2({
        placeholder: 'Pilih menu...',
        width: '100%'
    });
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush 