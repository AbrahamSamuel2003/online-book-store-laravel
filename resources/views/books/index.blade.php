@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Manage Books</h2>
        <p class="text-muted mb-0">
            View, add, edit, and delete books from the store.
        </p>
    </div>

    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
            Dashboard
        </a>

        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            + Add New Book
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="fw-semibold">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category?->name ?? 'Uncategorized' }}</td>
                            <td>₹{{ number_format($book->price, 2) }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                @if($book->stock > 0)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        disabled>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
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