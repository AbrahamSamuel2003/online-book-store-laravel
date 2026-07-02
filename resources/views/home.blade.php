@extends('layouts.app')

@section('content')
<div class="p-5 bg-white rounded shadow-sm text-center">
    <h1 class="fw-bold">Welcome to Online Book Store</h1>
    <p class="text-muted">Browse books, search titles, and check availability easily.</p>
    <a href="{{ route('books.index') }}" class="btn btn-primary">View Books</a>
</div>

<h3 class="mt-5 mb-3">Featured Books</h3>

<div class="row">
    @forelse($featuredBooks as $book)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" class="card-img-top" alt="{{ $book->title }}" style="height: 220px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5>{{ $book->title }}</h5>
                    <p class="text-muted mb-1">{{ $book->author }}</p>
                    <p class="fw-bold">Rs. {{ number_format($book->price, 2) }}</p>

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
    @empty
        <div class="col-12">
            <div class="alert alert-info">No books available yet.</div>
        </div>
    @endforelse
</div>

<h3 class="mt-5 mb-3">Recommended Books from Google</h3>

<div class="row" id="google-books-container">
    @forelse($apiBooks as $apiBook)
        @php
            $info = $apiBook['volumeInfo'] ?? [];
            $image = $info['imageLinks']['thumbnail'] ?? null;
        @endphp

        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($image)
                    <img
                        src="{{ $image }}"
                        class="card-img-top"
                        alt="{{ $info['title'] ?? 'Book cover' }}"
                        style="height: 220px; object-fit: cover;"
                    >
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                         style="height: 220px;">
                        <span class="text-muted">No Cover</span>
                    </div>
                @endif

                <div class="card-body">
                    <h6 class="card-title">
                        {{ $info['title'] ?? 'Untitled Book' }}
                    </h6>

                    <p class="text-muted mb-1">
                        Author:
                        {{ isset($info['authors']) ? implode(', ', $info['authors']) : 'Unknown' }}
                    </p>

                    <small class="text-muted">
                        {{ $info['publishedDate'] ?? 'Date not available' }}
                    </small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary">
                Google Books recommendations are currently unavailable.
            </div>
        </div>
    @endforelse
</div>

<div class="text-center mt-2">
    <button
        id="load-more-books"
        class="btn btn-outline-primary"
        data-start-index="4"
    >
        Load More Recommendations
    </button>
</div>

<script>
    const loadMoreButton = document.getElementById('load-more-books');
    const booksContainer = document.getElementById('google-books-container');

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.innerText = value;
        return element.innerHTML;
    }

    loadMoreButton.addEventListener('click', async function () {
        const startIndex = this.dataset.startIndex;

        this.disabled = true;
        this.innerText = 'Loading...';

        try {
            const response = await fetch(
                `{{ route('google-books.recommendations') }}?startIndex=${startIndex}`
            );

            const data = await response.json();

            if (!data.books || data.books.length === 0) {
                this.innerText = 'No More Recommendations';
                return;
            }

            data.books.forEach((apiBook) => {
                const info = apiBook.volumeInfo || {};
                const image = info.imageLinks?.thumbnail || '';
                const title = info.title || 'Untitled Book';
                const authors = info.authors
                    ? info.authors.join(', ')
                    : 'Unknown';
                const publishedDate = info.publishedDate || 'Date not available';

                const imageHtml = image
                    ? `<img src="${escapeHtml(image)}" class="card-img-top" alt="Book cover" style="height: 220px; object-fit: cover;">`
                    : `<div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                           <span class="text-muted">No Cover</span>
                       </div>`;

                booksContainer.insertAdjacentHTML('beforeend', `
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            ${imageHtml}
                            <div class="card-body">
                                <h6 class="card-title">${escapeHtml(title)}</h6>
                                <p class="text-muted mb-1">
                                    Author: ${escapeHtml(authors)}
                                </p>
                                <small class="text-muted">${escapeHtml(publishedDate)}</small>
                            </div>
                        </div>
                    </div>
                `);
            });

            this.dataset.startIndex = data.nextStartIndex;

            if (data.hasMore) {
                this.disabled = false;
                this.innerText = 'Load More Recommendations';
            } else {
                this.innerText = 'No More Recommendations';
            }
        } catch (error) {
            this.disabled = false;
            this.innerText = 'Try Again';
            alert('Unable to load more recommendations right now.');
        }
    });
</script>
@endsection