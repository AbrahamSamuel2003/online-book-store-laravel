@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Your Cart</h2>
        <p class="text-muted mb-0">
            Review your selected books before placing the order.
        </p>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
        Continue Shopping
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(count($cart) > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @foreach($cart as $item)
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-5">
                                <h5 class="mb-1">{{ $item['title'] }}</h5>
                                <p class="text-muted mb-0">
                                    ₹{{ number_format($item['price'], 2) }} each
                                </p>
                            </div>

                            <div class="col-md-3 mt-2 mt-md-0">
                                <form action="{{ route('cart.update', $item['book_id']) }}" method="POST">
                                    @csrf

                                    <label class="form-label mb-1">Quantity</label>

                                    <div class="input-group">
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="form-control"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            required
                                        >

                                        <button type="submit" class="btn btn-outline-primary">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-2 text-md-center mt-3 mt-md-0">
                                <strong>
                                    ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </strong>
                            </div>

                            <div class="col-md-2 text-md-end mt-3 mt-md-0">
                                <form action="{{ route('cart.remove', $item['book_id']) }}" method="POST">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Remove this book from cart?');"
                                    >
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Order Summary</h4>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <strong>₹{{ number_format($subtotal, 2) }}</strong>
                    </div>

                    <hr>

                    <p class="text-muted small">
                        Shipping and payment confirmation can be handled after the order is placed.
                    </p>

                    <hr class="my-4">

                    <h4 class="mb-3">Your Details</h4>

                    <form action="{{ route('checkout.preview') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Your Name</label>
                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control @error('customer_name') is-invalid @enderror"
                                value="{{ old('customer_name') }}"
                                placeholder="Enter your name"
                                required
                            >

                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input
                                type="email"
                                name="customer_email"
                                id="customer_email"
                                class="form-control @error('customer_email') is-invalid @enderror"
                                value="{{ old('customer_email') }}"
                                placeholder="Enter your email"
                                required
                            >

                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone Number</label>
                            <input
                                type="text"
                                name="customer_phone"
                                id="customer_phone"
                                class="form-control @error('customer_phone') is-invalid @enderror"
                                value="{{ old('customer_phone') }}"
                                placeholder="Enter phone number"
                                required
                            >

                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <textarea
                                name="address"
                                id="address"
                                rows="4"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter full delivery address"
                                required
                            >{{ old('address') }}</textarea>

                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <h4>Your cart is empty</h4>
            <p class="text-muted">
                Add books from the Books page to place an order.
            </p>

            <a href="{{ route('books.index') }}" class="btn btn-primary">
                Browse Books
            </a>
        </div>
    </div>
@endif
@endsection