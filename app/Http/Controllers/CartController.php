<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Book;


class CartController extends Controller
{
public function addToCart(Request $request, $id)
{
    $book = Book::findOrFail($id);
    $cart = Session::get('cart', []);
    

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => 1

        ];
    }

    Session::put('cart', $cart);
    Session::put('cart_count', array_sum(array_column($cart, 'quantity'))); // Update count
    $totalPrice = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    return response()->json([
        'message' => 'Book added to cart!',
        'cart_count' => Session::get('cart_count', 0),
        'total_price' => $totalPrice
    ]);
}

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $totalPrice = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });
        return view('cart.index', compact('cart','totalPrice'));
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
    $cart = Session::get('cart', []);
  

    if (isset($cart[$id])) {
        $newQuantity = (int) $request->quantity;

        if ($newQuantity < 1) {
            unset($cart[$id]); // Remove item
        } else {
            $cart[$id]['quantity'] = $newQuantity;
        }
    }

    Session::put('cart', $cart);
    Session::put('cart_count', array_sum(array_column($cart, 'quantity')));

  $totalPrice = collect($cart)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });
    return response()->json([
        'message' => isset($cart[$id]) ? 'Cart updated!' : 'Item removed from cart.',
        'cart_count' => Session::get('cart_count', 0),
        'total_price' => $totalPrice
    ]);
}
}