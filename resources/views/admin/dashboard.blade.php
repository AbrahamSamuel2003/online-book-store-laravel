@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Admin Dashboard</h2>
        <p class="text-muted mb-0">Manage books and view store details.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.books.index') }}" class="btn btn-primary">
            Manage Books
        </a>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                Logout
            </button>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Total Books</p>
                <h2 class="fw-bold mb-0">{{ $totalBooks }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Available Books</p>
                <h2 class="fw-bold text-success mb-0">{{ $availableBooks }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Out of Stock</p>
                <h2 class="fw-bold text-danger mb-0">{{ $outOfStockBooks }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Recently Added Books</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBooks as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>₹{{ number_format($book->price, 2) }}</td>
                            <td>
                                @if($book->stock > 0)
                                    <span class="badge bg-success">
                                        {{ $book->stock }} Available
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No books found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection