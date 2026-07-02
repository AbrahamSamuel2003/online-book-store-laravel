<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function home()
    {
        $featuredBooks = Book::latest()->take(4)->get();

        try {
            $response = Http::timeout(10)->get(
                'https://www.googleapis.com/books/v1/volumes',
                [
                    'q' => 'web development',
                    'maxResults' => 4,
                    'key' => env('GOOGLE_BOOKS_API_KEY'),
                ]
            );

            $apiBooks = $response->successful()
                ? ($response->json('items') ?? [])
                : [];
        } catch (\Exception $e) {
            $apiBooks = [];
        }

        return view('home', compact('featuredBooks', 'apiBooks'));
    }


    public function loadMoreRecommendations(Request $request)
    {
        $startIndex = (int) $request->query('startIndex', 4);

        try {
            $response = Http::timeout(10)->get(
                'https://www.googleapis.com/books/v1/volumes',
                [
                    'q' => 'web development',
                    'startIndex' => $startIndex,
                    'maxResults' => 4,
                    'key' => env('GOOGLE_BOOKS_API_KEY'),
                ]
            );

            $books = $response->successful()
                ? ($response->json('items') ?? [])
                : [];

            return response()->json([
                'books' => $books,
                'nextStartIndex' => $startIndex + 4,
                'hasMore' => count($books) === 4,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'books' => [],
                'nextStartIndex' => $startIndex,
                'hasMore' => false,
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('author', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('books.index', compact('books', 'search'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}