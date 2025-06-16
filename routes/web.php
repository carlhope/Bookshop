<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;



use App\Http\Controllers\BookController;
use Inertia\Inertia;
Route::middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/books/{id}', function ($id) {
    $book = \App\Models\Book::findOrFail($id);
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));

    return Inertia::render('BookShow', [
        'book' => $book,
        'cart' => $cart,
        'cartCount' => $cartCount,
    ]);
});
Route::get('/cart', function () {
    $cart = session('cart', []);
    return Inertia::render('Cart', [
        'cart' => $cart,
        'cartCount' => array_sum(array_column($cart, 'quantity'))

    ]);
})->name('cart.view');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});


Route::get('/', fn () => Inertia::render('Home'));

Route::get('/about', fn () => Inertia::render('About'));



Route::get('/books', function () {
    return Inertia::render('BooksIndex', [
        'books' => \App\Models\Book::all(),
    ]);
});





Route::get('/clear-cart', function () {
    session()->forget('cart');
    session()->forget('cart_count');
    return 'Cart cleared!';
});
