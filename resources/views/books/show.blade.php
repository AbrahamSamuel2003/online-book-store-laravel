@extends('layouts.app')

@section('content')
<a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm mb-4">Back to Books</a>

<div class="card shadow-sm">
    <div class="row g-0">
        @if($book->cover_image)
            <div class="col-md-4">
                <img src="{{ $book->cover_image }}" class="img-fluid rounded-start w-100" alt="{{ $book->title }}" style="height: 100%; min-height: 320px; object-fit: cover;">
            </div>
        @endif
        <div class="col-md-8">
            <div class="card-body">
                <h1 class="h3">{{ $book->title }}</h1>
                <p class="text-muted">by {{ $book->author }}</p>
                <p class="fw-bold fs-4">Rs. {{ number_format($book->price, 2) }}</p>

                @if($book->stock > 0)
                    <span class="badge bg-success mb-3">Available</span>
                @else
                    <span class="badge bg-danger mb-3">Out of Stock</span>
                @endif

                @if($book->stock > 0)
                    <form action="{{ route('cart.add', $book) }}" method="POST" class="mt-3 mb-4">
                        @csrf

                        <div class="row g-2 align-items-end">
                            <div class="col-sm-4">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    class="form-control"
                                    value="1"
                                    min="1"
                                    max="{{ $book->stock }}"
                                    required
                                >
                            </div>

                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary mt-3 mb-4" disabled>
                        Out of Stock
                    </button>
                @endif

                <p>{{ $book->description }}</p>

                <ul class="list-group list-group-flush mt-4">
                    @if($book->category)
                        <li class="list-group-item px-0"><strong>Category:</strong> {{ $book->category->name }}</li>
                    @endif
                    @if($book->isbn)
                        <li class="list-group-item px-0"><strong>ISBN:</strong> {{ $book->isbn }}</li>
                    @endif
                    @if($book->published_year)
                        <li class="list-group-item px-0"><strong>Published Year:</strong> {{ $book->published_year }}</li>
                    @endif
                    <li class="list-group-item px-0"><strong>Stock:</strong> {{ $book->stock }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection