<x-app-layout>
<div class="row mb-4">
    <div class="col-12">
        <form method="GET" action="" class="d-flex align-items-center">
            <label for="category" class="me-2 mb-0">Kategori:</label>
            <select name="category" id="category" class="form-select w-auto me-2">
                <option value="">Semua</option>
                <option value="Hot Coffee" {{ request('category') == 'Hot Coffee' ? 'selected' : '' }}>Hot Coffee</option>
                <option value="Cold Coffee" {{ request('category') == 'Cold Coffee' ? 'selected' : '' }}>Cold Coffee</option>
                <option value="Pastries" {{ request('category') == 'Pastries' ? 'selected' : '' }}>Pastries</option>
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
            @if($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->name }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $menu->name }}</h5>
                <p class="card-text">{{ $menu->description }}</p>
                <p class="card-text"><strong>Price: ${{ number_format($menu->price, 2) }}</strong></p>
                <a href="{{ route('menus.show', $menu) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-app-layout>
