<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use Inertia\Inertia;

// 🔹 Authentication Routes (Move this outside session middleware)
Auth::routes();

// ✅ Apply session-related middleware globally
Route::middleware([
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
])->group(function () {
    // 🔹 Cart Routes
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', function () {
        $cart = session('cart', []);
        return Inertia::render('Cart', [
            'cart' => $cart,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    })->name('cart.view');

    // 🔹 Book Routes
    Route::get('/books', function () {
        $cart = session('cart', []);
        return Inertia::render('BooksIndex', [
            'books' => \App\Models\Book::all(),
            'cart' => $cart,
        ]);
    });

    Route::get('/books/{id}', function ($id) {
        $book = \App\Models\Book::findOrFail($id);
        $cart = session('cart', []);
        return Inertia::render('BookShow', [
            'book' => $book,
            'cart' => $cart,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    });

    // 🔹 Clear Cart Route
    Route::get('/clear-cart', function () {
        session()->forget('cart');
        session()->forget('cart_count');
        return 'Cart cleared!';
    });
});

// ✅ Home & About Pages
Route::get('/', fn () => Inertia::render('Home'));

Route::middleware(['auth'])->group(function () {
    Route::get('/about', fn () => Inertia::render('About'));
    Route::get('/home', fn () => Inertia::render('Home'));
     Route::get('/books/create', function () {
        return Inertia::render('BookCreate');
    });

    Route::post('/books', [BookController::class, 'create']);
    Route::put('/books/{book}', [BookController::class, 'update']);
});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('web');

