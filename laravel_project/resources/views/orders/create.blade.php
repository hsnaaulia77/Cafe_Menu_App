<x-app-layout>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Place New Order</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="notes" class="form-label">Special Instructions</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            
            <h4>Selected Items</h4>
            <div id="order-items">
                <!-- Order items will be added here dynamically -->
            </div>
            
            <div class="mt-4">
                <h5>Total: $<span id="total-amount">0.00</span></h5>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Place Order</button>
        </form>
    </div>
</div>
</x-app-layout>
