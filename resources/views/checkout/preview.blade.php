@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Confirm Your Order</h2>
                <p class="text-muted mb-0">
                    Review your details and selected books before placing the order.
                </p>
            </div>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                Back to Cart
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="mb-3">Customer Details</h4>

                <p class="mb-2">
                    <strong>Name:</strong> {{ $validated['customer_name'] }}
                </p>

                <p class="mb-2">
                    <strong>Email:</strong> {{ $validated['customer_email'] }}
                </p>

                <p class="mb-2">
                    <strong>Phone:</strong> {{ $validated['customer_phone'] }}
                </p>

                <p class="mb-0">
                    <strong>Address:</strong><br>
                    {{ $validated['address'] }}
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="mb-3">Order Items</h4>

                @foreach($cart as $item)
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <div>
                            <h6 class="mb-1">{{ $item['title'] }}</h6>
                            <span class="text-muted">
                                ₹{{ number_format($item['price'], 2) }}
                                × {{ $item['quantity'] }}
                            </span>
                        </div>

                        <strong>
                            ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </strong>
                    </div>
                @endforeach

                <div class="d-flex justify-content-between pt-3">
                    <h5>Total Amount</h5>
                    <h5>₹{{ number_format($subtotal, 2) }}</h5>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.place-order') }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-success w-100">
                Confirm and Place Order
            </button>
        </form>
    </div>
</div>
@endsection