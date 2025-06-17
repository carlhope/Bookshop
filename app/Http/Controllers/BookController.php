<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;


class BookController extends Controller
{
    public function index()
{
     \Log::info('BooksIndex cart:', session('cart'));
return Inertia::render('BooksIndex', [
    'books' => Book::all(),
    'cart' => session('cart', []), // Ensure cart is passed to Vue
]);
}

    public function show($id)
{
    $book = Book::findOrFail($id);
    return view('books.show', compact('book'));
}
public function apiIndex()
{
    return response()->json(Book::all());
}

public function apiShow($id)
{
    return response()->json(Book::findOrFail($id));
}
}