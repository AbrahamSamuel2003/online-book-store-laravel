@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Customer Orders</h2>
        <p class="text-muted mb-0">
            View all orders placed by customers.
        </p>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        Back to Dashboard
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Books</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $order->customer_name }}</div>
                                    <div class="small text-muted">{{ $order->customer_email }}</div>
                                    <div class="small text-muted">{{ $order->customer_phone }}</div>
                                    <div class="small text-muted">{{ $order->address }}</div>
                                </td>
                                <td>
                                    @forelse($order->items as $item)
                                        {{ $item->book?->title ?? 'Deleted Book' }} ({{ $item->quantity }})@if(!$loop->last), @endif
                                    @empty
                                        <span class="text-muted">No items</span>
                                    @endforelse
                                </td>
                                <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()"
                                        >
                                            <option value="Pending" @selected($order->status === 'Pending')>
                                                Pending
                                            </option>

                                            <option value="Confirmed" @selected($order->status === 'Confirmed')>
                                                Confirmed
                                            </option>

                                            <option value="Delivered" @selected($order->status === 'Delivered')>
                                                Delivered
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">
                No customer orders have been placed yet.
            </p>
        @endif
    </div>
</div>
@endsection