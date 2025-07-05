@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Kelola Promosi untuk Menu: <b>{{ $menuItem->nama }}</b></h3>
    <form method="POST" action="{{ route('menu_items.updatePromotions', $menuItem->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="promotion_ids" class="form-label">Pilih Promosi:</label>
            <select name="promotion_ids[]" id="promotion_ids" class="form-control" multiple>
                @foreach($allPromotions as $promo)
                    <option value="{{ $promo->id }}" {{ $menuItem->promotions->contains($promo->id) ? 'selected' : '' }}>
                        {{ $promo->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Promosi</button>
        <a href="{{ route('menu_items.index') }}" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
@endsection 