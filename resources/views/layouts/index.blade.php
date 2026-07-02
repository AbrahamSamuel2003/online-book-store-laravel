@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
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
    <div>
        <h2 class="mb-1">All Books</h2>
        <p class="text-muted mb-0">Browse the books available in our store.</p>
    </div>

    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        Back to Home
    </a>
</div>

<div class="row">
    @forelse($books as $book)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-dark border mb-3 align-self-start">
                        {{ $book->category?->name ?? 'Uncategorized' }}
                    </span>

                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="text-muted mb-2">By {{ $book->author }}</p>

                    <p class="fw-bold fs-5 mb-2">₹{{ number_format($book->price, 2) }}</p>

                    @if($book->stock > 0)
                        <p class="text-success fw-semibold">
                            Available ({{ $book->stock }} in stock)
                        </p>
                    @else
                        <p class="text-danger fw-semibold">
                            Out of Stock
                        </p>
                    @endif

                    <a href="{{ route('books.show', $book) }}"
                       class="btn btn-primary mt-auto">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning">
                No books are available currently.
            </div>
        </div>
    @endforelse
</div>
@endsection