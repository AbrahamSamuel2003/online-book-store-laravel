<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();

        $availableBooks = Book::where('stock', '>', 0)->count();

        $outOfStockBooks = Book::where('stock', 0)->count();

        $recentBooks = Book::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'availableBooks',
            'outOfStockBooks',
            'recentBooks'
        ));
    }
}