@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Books</h1>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Back Home</a>
</div>

<form action="{{ route('books.index') }}" method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-8">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by book title or author..."
                value="{{ $search ?? '' }}"
            >
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Search
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100">
                Clear
            </a>
        </div>
    </div>
</form>

<div class="row">
    @forelse($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" class="card-img-top" alt="{{ $book->title }}" style="height: 240px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="text-muted mb-1">{{ $book->author }}</p>

                    @if($book->category)
                        <p class="small text-muted mb-1">{{ $book->category->name }}</p>
                    @endif

                    <p class="fw-bold">Rs. {{ number_format($book->price, 2) }}</p>

                    @if($book->stock > 0)
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif

                    <div class="mt-3">
                        @if($book->stock > 0)
                            <form action="{{ route('cart.add', $book) }}" method="POST" class="mt-auto">
                                @csrf

                                <div class="input-group mb-2">
                                    <input
                                        type="number"
                                        name="quantity"
                                        class="form-control"
                                        value="1"
                                        min="1"
                                        max="{{ $book->stock }}"
                                        required
                                    >
                                    <button type="submit" class="btn btn-success">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary mt-auto" disabled>
                                Out of Stock
                            </button>
                        @endif

                        <a href="{{ route('books.show', $book) }}"
                           class="btn btn-outline-primary mt-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No books found.</div>
        </div>
    @endforelse
</div>
@endsection