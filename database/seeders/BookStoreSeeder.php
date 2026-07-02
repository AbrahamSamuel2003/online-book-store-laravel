<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookStoreSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Programming',
            'Fiction',
            'Self Help',
            'Business',
            'Science',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }

        $programming = Category::where('name', 'Programming')->first();
        $fiction = Category::where('name', 'Fiction')->first();
        $selfHelp = Category::where('name', 'Self Help')->first();
        $business = Category::where('name', 'Business')->first();
        $science = Category::where('name', 'Science')->first();

        $books = [
            [
                'category_id' => $programming->id,
                'title' => 'Laravel Up and Running',
                'author' => 'Matt Stauffer',
                'description' => 'A practical guide to building modern web applications using Laravel.',
                'price' => 599.00,
                'stock' => 12,
                'isbn' => '9781492041214',
                'published_year' => 2019,
            ],
            [
                'category_id' => $programming->id,
                'title' => 'PHP and MySQL Web Development',
                'author' => 'Luke Welling',
                'description' => 'A beginner-friendly book for learning PHP and MySQL web development.',
                'price' => 499.00,
                'stock' => 8,
                'isbn' => '9780672329166',
                'published_year' => 2016,
            ],
            [
                'category_id' => $programming->id,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'A guide to writing clean, maintainable, and professional code.',
                'price' => 699.00,
                'stock' => 10,
                'isbn' => '9780132350884',
                'published_year' => 2008,
            ],
            [
                'category_id' => $fiction->id,
                'title' => 'Harry Potter and the Sorcerer Stone',
                'author' => 'J.K. Rowling',
                'description' => 'A fantasy novel about a young wizard and his magical journey.',
                'price' => 399.00,
                'stock' => 15,
                'isbn' => '9780590353427',
                'published_year' => 1997,
            ],
            [
                'category_id' => $fiction->id,
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'description' => 'A fantasy adventure story about Bilbo Baggins and his journey.',
                'price' => 450.00,
                'stock' => 6,
                'isbn' => '9780547928227',
                'published_year' => 1937,
            ],
            [
                'category_id' => $selfHelp->id,
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'A practical book about building good habits and breaking bad ones.',
                'price' => 550.00,
                'stock' => 20,
                'isbn' => '9780735211292',
                'published_year' => 2018,
            ],
            [
                'category_id' => $selfHelp->id,
                'title' => 'Deep Work',
                'author' => 'Cal Newport',
                'description' => 'A book about improving focus and productivity in a distracted world.',
                'price' => 480.00,
                'stock' => 9,
                'isbn' => '9781455586691',
                'published_year' => 2016,
            ],
            [
                'category_id' => $business->id,
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'description' => 'A business book about building startups through continuous innovation.',
                'price' => 620.00,
                'stock' => 7,
                'isbn' => '9780307887894',
                'published_year' => 2011,
            ],
            [
                'category_id' => $business->id,
                'title' => 'Zero to One',
                'author' => 'Peter Thiel',
                'description' => 'A book about startups, innovation, and building unique businesses.',
                'price' => 530.00,
                'stock' => 11,
                'isbn' => '9780804139298',
                'published_year' => 2014,
            ],
            [
                'category_id' => $science->id,
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'description' => 'A science book explaining space, time, black holes, and the universe.',
                'price' => 500.00,
                'stock' => 5,
                'isbn' => '9780553380163',
                'published_year' => 1988,
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['isbn' => $book['isbn']],
                $book
            );
        }
    }
}