<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Menu App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Coffee Menu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menus.index') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.view') }}">Keranjang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @isset($header)
            <div class="mb-4">
                {{ $header }}
            </div>
        @endisset
        {{ $slot }}
    </main>
</body>
</html>