<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
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