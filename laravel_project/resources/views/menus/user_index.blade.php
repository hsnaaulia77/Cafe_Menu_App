<x-app-layout>
<div class="row mb-4">
    <div class="col-12">
        <form method="GET" action="" class="d-flex align-items-center">
            <label for="category" class="me-2 mb-0">Kategori:</label>
            <select name="category" id="category" class="form-select w-auto me-2">
                <option value="">Semua</option>
                <option value="Makanan" {{ request('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ request('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Camilan" {{ request('category') == 'Camilan' ? 'selected' : '' }}>Camilan</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Our Menu</h1>
    </div>
</div>

<div class="row">
    @foreach($menus as $menu)
    <div class="col-md-4 mb-4">
        <div class="card">
            @if($menu->gambar)
                <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top" alt="{{ $menu->nama }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $menu->nama }}</h5>
                <p class="card-text">{{ $menu->deskripsi }}</p>
                <p class="card-text"><strong>Harga: Rp{{ number_format($menu->harga, 0, ',', '.') }}</strong></p>
                <a href="{{ route('menus.show', $menu) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-app-layout>
