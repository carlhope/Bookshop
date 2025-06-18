<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;


class BookController extends Controller
{
    public function index()
{
return Inertia::render('BooksIndex', [
    'books' => Book::all(),
    'cart' => session('cart', []),
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
public function create(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    Book::create($validated);
    return redirect()->back()->with('success', 'Book saved successfully!');
}

public function update(Request $request, Book $book)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $book->update($validated);
    return redirect()->back()->with('success', 'Book updated successfully!');
}
}
