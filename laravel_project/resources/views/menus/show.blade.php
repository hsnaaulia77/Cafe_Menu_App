<x-app-layout>
<div class="row">
    <div class="col-md-6">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid rounded" alt="{{ $menu->name }}">
        @endif
    </div>
    <div class="col-md-6">
        <h1>{{ $menu->name }}</h1>
        <p class="lead">{{ $menu->description }}</p>
        <p class="h3">${{ number_format($menu->price, 2) }}</p>
        
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
</div>
</x-app-layout>
