<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Laravel\Pail\ValueObjects\Origin\Console;


class CartController extends Controller
{

public function addToCart(Request $request, $id)
{
    $request->session()->start();

    session()->put('ping', now());
    $book = Book::findOrFail($id);
    $bookId = (string) $book->id;

    $cart = session('cart', []);
     \Log::info('Beginning Session cart contents:', $cart);

    // 🛠 Re-key cart if it's a numerically indexed array (e.g. from earlier tests)
    if (array_is_list($cart)) {
        $converted = [];
        foreach ($cart as $item) {
            if (isset($item['book_id'])) {
                $converted[(string) $item['book_id']] = $item;
            }
        }
        $cart = $converted;
    }

    // 🧠 Add or increment the book
    if (isset($cart[$bookId])) {
        $cart[$bookId]['quantity']++;
    } else {
        $cart[$bookId] = [
            'book_id' => $book->id,
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => 1,
        ];
    }

    // 💾 Store back into session
    session(['cart' => $cart]);
    session(['cart_count' => array_sum(array_column($cart, 'quantity'))]);

    // 📋 Log for debugging
    Log::info('Cart updated:', $cart);

    // 🧪 Response for Vue to inspect cart data while building
    \Log::info('Session cart contents:', $cart);
   return response()->json([
    'cart' => $cart,
    'cartCount' => session('cart_count', 0),
]);


}


 public function viewCart()
{
    $cart = Session::get('cart', []);

    $totalPrice = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

    return \Inertia\Inertia::render('Cart', [
        'cart' => array_values($cart),
        'cartCount' => Session::get('cart_count', 0),
        'totalPrice' => $totalPrice,
    ]);
}

   public function removeFromCart($id)
{
    $cart = Session::get('cart', []);
    
    unset($cart[$id]);
    Session::put('cart', $cart);
    Session::put('cart_count', array_sum(array_column($cart, 'quantity'))); // Update count
     $totalPrice = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    return response()->json([
        'message' => 'Book removed from cart.',
        'cart_count' => Session::get('cart_count', 0),
        'total_price' => $totalPrice
    ]);
} 
public function updateQuantity(Request $request, $id)
{
    $id = (string) $id;

    $cart = Session::get('cart', []);
    $newQuantity = max(0, (int) $request->quantity);

    // 🔍 This is where it’s failing: item isn't in cart
   if (!array_key_exists($id, $cart)) {
    return response()->json([
        'message' => 'Item not found.',
        'cart_count' => session('cart_count', 0),
        'total_price' => 0
    ], 400);
}


    if ($newQuantity < 1) {
        unset($cart[$id]);
    } else {
        $cart[$id]['quantity'] = $newQuantity;
    }

    Session::put('cart', $cart);
    Session::put('cart_count', array_sum(array_column($cart, 'quantity')));

    $totalPrice = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

    return back();
}
}