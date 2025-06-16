<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use Inertia\Inertia;


Route::get('/', fn () => Inertia::render('Home'));

Route::get('/about', fn () => Inertia::render('About'));



Route::get('/books', function () {
    return Inertia::render('BooksIndex', [
        'books' => \App\Models\Book::all(),
    ]);
});

Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
