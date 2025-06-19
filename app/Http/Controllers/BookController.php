<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
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

public function showCreateForm() 
{
    $categories = Category::all(['id', 'name']);
    return Inertia::render('BookCreate', ['categories' => $categories]);
}
public function create(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'price' => 'nullable|numeric|min:0',
        'cover_image' => 'nullable|url', 
    ]);

    Book::create($validated);
    return redirect()->route('books.index')->with('success', 'Book created!');
}

public function update(Request $request, $id)
{
    $book = Book::findOrFail($id);
    \Log::info('Book before update:', ['book' => $book]);
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'price' => 'nullable|numeric|min:0',
        'cover_image' => 'nullable|url', 
    ]);
    $updated = $book->update($validated);
    $book->update($validated);
    return redirect()->back()->with('success', 'Book updated successfully!');
}
}
