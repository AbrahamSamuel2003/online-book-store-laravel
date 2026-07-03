<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->quantity;

        if ($quantity > $book->stock) {
            return back()->with('error', 'Requested quantity is not available in stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            $newQuantity = $cart[$book->id]['quantity'] + $quantity;

            if ($newQuantity > $book->stock) {
                return back()->with('error', 'You cannot add more than the available stock.');
            }

            $cart[$book->id]['quantity'] = $newQuantity;
        } else {
            $cart[$book->id] = [
                'book_id' => $book->id,
                'title' => $book->title,
                'price' => (float) $book->price,
                'quantity' => $quantity,
                'cover_image' => $book->cover_image,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Book added to cart successfully.');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$book->id])) {
            return redirect()->route('cart.index');
        }

        $quantity = (int) $request->quantity;

        if ($quantity > $book->stock) {
            return back()->with('error', 'Requested quantity is not available in stock.');
        }

        $cart[$book->id]['quantity'] = $quantity;

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Book $book)
    {
        $cart = session()->get('cart', []);

        unset($cart[$book->id]);

        session()->put('cart', $cart);

        return back()->with('success', 'Book removed from cart.');
    }
}