@extends('layouts.app')

@section('content')
<div class="p-5 bg-white rounded shadow-sm text-center">
    <h1 class="fw-bold">Welcome to Online Book Store</h1>
    <p class="text-muted">Browse books, search titles, and check availability easily.</p>
    <a href="{{ route('books.index') }}" class="btn btn-primary">View Books</a>
</div>

<h3 class="mt-5 mb-3">Featured Books</h3>

<div class="row">
    @foreach($featuredBooks as $book)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>{{ $book->title }}</h5>
                    <p class="text-muted mb-1">{{ $book->author }}</p>
                    <p class="fw-bold">₹{{ $book->price }}</p>

                    @if($book->stock > 0)
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection