<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        session()->put('checkout_details', $validated);

        return view('checkout.preview', compact('cart', 'subtotal', 'validated'));
    }

    public function placeOrder()
    {
        $cart = session()->get('cart', []);
        $customerDetails = session()->get('checkout_details');

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        if (!$customerDetails) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Please enter your details before checkout.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $customerDetails) {
                $totalAmount = 0;

                foreach ($cart as $item) {
                    $book = Book::lockForUpdate()->findOrFail($item['book_id']);

                    if ($book->stock < $item['quantity']) {
                        throw new \Exception(
                            $book->title . ' does not have enough stock available.'
                        );
                    }

                    $totalAmount += $book->price * $item['quantity'];
                }

                $order = Order::create([
                    'customer_name' => $customerDetails['customer_name'],
                    'customer_email' => $customerDetails['customer_email'],
                    'customer_phone' => $customerDetails['customer_phone'],
                    'address' => $customerDetails['address'],
                    'total_amount' => $totalAmount,
                    'status' => 'Pending',
                ]);

                foreach ($cart as $item) {
                    $book = Book::lockForUpdate()->findOrFail($item['book_id']);

                    $order->items()->create([
                        'book_id' => $book->id,
                        'quantity' => $item['quantity'],
                        'price' => $book->price,
                    ]);

                    $book->decrement('stock', $item['quantity']);
                }

                return $order;
            });

            session()->forget('cart');
            session()->forget('checkout_details');

            $order->load('items.book');

            return view('checkout.success', compact('order'));
        } catch (\Exception $e) {
            return redirect()
                ->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }
}