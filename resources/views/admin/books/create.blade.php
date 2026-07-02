@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Add New Book</h2>
        <p class="text-muted mb-0">Enter the details of the book to add it to the store.</p>
    </div>

    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
        Back to Manage Books
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.books.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Book Title</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input
                        type="text"
                        name="author"
                        id="author"
                        class="form-control @error('author') is-invalid @enderror"
                        value="{{ old('author') }}"
                        required
                    >
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select
                        name="category_id"
                        id="category_id"
                        class="form-select @error('category_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}"
                        min="0"
                        step="0.01"
                        required
                    >
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input
                        type="number"
                        name="stock"
                        id="stock"
                        class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock') }}"
                        min="0"
                        required
                    >
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input
                        type="text"
                        name="isbn"
                        id="isbn"
                        class="form-control @error('isbn') is-invalid @enderror"
                        value="{{ old('isbn') }}"
                    >
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="published_year" class="form-label">Published Year</label>
                    <input
                        type="number"
                        name="published_year"
                        id="published_year"
                        class="form-control @error('published_year') is-invalid @enderror"
                        value="{{ old('published_year') }}"
                        min="1000"
                        max="2100"
                    >
                    @error('published_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Book
            </button>

            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary ms-2">
                Cancel
            </a>
        </form>
    </div>
</div>
@endsection