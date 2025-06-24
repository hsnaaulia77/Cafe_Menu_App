@extends('layouts.cashier')
@section('content')
<div class="container mt-5">
    <h1>Input Pesanan Manual (Walk-in)</h1>
    @role('cashier')
        <form action="{{ route('cashier.orders.store') }}" method="POST">
            @csrf
            <x-input-field name="customer_name" label="Nama Customer" :value="old('customer_name')" />
            <x-input-field name="order_total" label="Total" type="number" :value="old('order_total')" />
            <button type="submit" class="btn btn-warning">Buat Pesanan</button>
        </form>
    @endrole
</div>
@endsection 