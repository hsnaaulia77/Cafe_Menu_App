<x-app-layout>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Your Orders</h1>
    </div>
</div>

<div class="row">
    @foreach($orders as $order)
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                Order #{{ $order->id }} - {{ $order->created_at->format('M d, Y H:i') }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Status: {{ ucfirst($order->status) }}</h5>
                <p class="card-text">Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
                
                <h6>Order Items:</h6>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                    <li class="list-group-item">
                        {{ $item->menu->name }} x {{ $item->quantity }} - ${{ number_format($item->price * $item->quantity, 2) }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-app-layout>
