<x-app-layout>
<div class="container">
    <h1>Shopping Cart</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count(session('cart', [])) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr>
                            <td>{{ $details['name'] }}</td>
                            <td>${{ $details['price'] }}</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td>${{ $details['price'] * $details['quantity'] }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>${{ $total }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('menus.index') }}">Continue shopping</a>
        </div>
    @endif
</div>
</x-app-layout>
