<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            Online Book Store
        </a>

        <div>
            @auth
                <a class="btn btn-primary btn-sm me-2" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a class="btn btn-warning btn-sm me-2" href="{{ route('admin.books.index') }}">
                    Manage Books
                </a>

                @if(Route::has('admin.orders.index'))
                    <a class="btn btn-info btn-sm me-2" href="{{ route('admin.orders.index') }}">
                        Orders
                    </a>
                @endif

                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf

                    <button type="submit" class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a class="btn btn-outline-light btn-sm me-2" href="{{ route('home') }}">
                    Home
                </a>

                <a class="btn btn-outline-light btn-sm me-2" href="{{ route('books.index') }}">
                    Books
                </a>

                <a class="btn btn-outline-light btn-sm me-2" href="{{ route('cart.index') }}">
                    Cart
                    <span class="badge bg-warning text-dark">
                        {{ collect(session('cart', []))->sum('quantity') }}
                    </span>
                </a>

                <a class="btn btn-warning btn-sm" href="{{ route('admin.login') }}">
                    Admin Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>