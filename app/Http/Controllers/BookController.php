<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Log;



class BookController extends Controller
{
    public function index()
{
    $books = Book::with('category')->paginate(120);
    \Log::info($books);
        return Inertia::render('BooksIndex', [
            'books' => $books,
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
    public function create(StoreBookRequest $request)
    {
        Book::create($request->validated());
        return redirect()->route('books.index')->with('success', 'Book created!');
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);

        \Log::info('Book before update:', ['book' => $book]);

        $book->update($request->validated());

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

}
