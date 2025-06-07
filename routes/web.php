<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

Route::get('/', function () {
    return view('home');
});


Route::get('/books', [BooksController::class, 'index']);

Route::get('/books/{id}', [BooksController::class, 'show'])->name('books.show');
