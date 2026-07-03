@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <h2 class="text-success fw-bold mb-3">
                    Order Placed Successfully!
                </h2>

                <p class="text-muted mb-4">
                    Your order has been received and is now visible to the store administrator.
                </p>

                <div class="text-start border rounded p-4 mb-4">
                    <h5 class="mb-3">Order #{{ $order->id }}</h5>

                    <p class="mb-2">
                        <strong>Customer:</strong> {{ $order->customer_name }}
                    </p>

                    <p class="mb-2">
                        <strong>Phone:</strong> {{ $order->customer_phone }}
                    </p>

                    <p class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-warning text-dark">
                            {{ $order->status }}
                        </span>
                    </p>

                    <h6>Books Ordered</h6>

                    <p class="mb-3">
                        @foreach($order->items as $item)
                            {{ $item->book->title }} ({{ $item->quantity }})@if(!$loop->last), @endif
                        @endforeach
                    </p>

                    <h5>
                        Total Amount:
                        ₹{{ number_format($order->total_amount, 2) }}
                    </h5>
                </div>

                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection