@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary mb-4">
            ← Back to Books
        </a>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="height: 280px;">
                            <span class="text-muted fs-5">Book Cover</span>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <span class="badge bg-secondary mb-2">
                            {{ $book->category?->name ?? 'Uncategorized' }}
                        </span>

                        <h1 class="fw-bold">{{ $book->title }}</h1>

                        <p class="fs-5 text-muted">
                            By {{ $book->author }}
                        </p>

                        <h3 class="text-primary mb-3">
                            ₹{{ number_format($book->price, 2) }}
                        </h3>

                        @if($book->stock > 0)
                            <p class="text-success fw-semibold">
                                Available — {{ $book->stock }} copies in stock
                            </p>
                        @else
                            <p class="text-danger fw-semibold">
                                Currently Out of Stock
                            </p>
                        @endif

                        <hr>

                        <p>
                            <strong>ISBN:</strong>
                            {{ $book->isbn ?? 'Not available' }}
                        </p>

                        <p>
                            <strong>Published Year:</strong>
                            {{ $book->published_year ?? 'Not available' }}
                        </p>

                        <p>
                            <strong>Description:</strong><br>
                            {{ $book->description ?? 'No description available for this book.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection