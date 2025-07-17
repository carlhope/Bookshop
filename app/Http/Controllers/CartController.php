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

    $book = Book::findOrFail($id);
    $bookId = (string) $book->id;

    $cart = session('cart', []);


    if (array_is_list($cart)) {
        $converted = [];
        foreach ($cart as $item) {
            if (isset($item['book_id'])) {
                $converted[(string) $item['book_id']] = $item;
            }
        }
        $cart = $converted;
    }


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

    $this->updateCartSession($cart);

   return back()->with([
        'cart_count' => session('cart_count', 0)
    ]);
}

 public function viewCart()
{
    session()->put('cart_last_interaction', now());
    $cart = Session::get('cart', []);

    $totalPrice = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

    return Inertia::render('Cart', [
        'cart' => array_values($cart),
        'cartCount' => Session::get('cart_count', 0),
        'totalPrice' => $totalPrice,
    ]);
}

   public function removeFromCart($id)
{
    $cart = Session::get('cart', []);

    unset($cart[$id]);
     $totalPrice = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });
    $this->updateCartSession($cart);


 return back()->with([
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

    if (!array_key_exists($id, $cart)) {
       return back()->withErrors(['message' => 'Item not found.']);

    }

    if ($newQuantity < 1) {
        unset($cart[$id]);
    } else {
        $cart[$id]['quantity'] = $newQuantity;
    }

    $this->updateCartSession($cart);


  return back()->with([
    'cart_count' => session('cart_count', 0),
    'total_price' => collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity'])
]);
}
private function updateCartSession($cart)
{
    session()->put('cart_last_interaction', now());
    Session::put('cart', $cart);
    Session::put('cart_count', array_sum(array_column($cart, 'quantity')));
}
}
