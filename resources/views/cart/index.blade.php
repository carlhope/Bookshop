@extends('layouts.app')
@section('content')
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>

    @if(session('cart'))
        <div id="cart-container">
            <ul class="space-y-4">
                @foreach(session('cart') as $id => $book)
                    <div class="cart-item bg-white shadow-md p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $book['title'] }}</h3>
                            <p class="text-gray-600">Price: £{{ $book['price'] }}</p>

                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-2">
                                <button class="decrease-quantity bg-red-500 text-white px-2 py-1 rounded"
                                    data-id="{{ $id }}">−</button>
                                <span class="quantity-value text-lg font-bold" data-id="{{ $id }}">{{ $book['quantity'] }}</span>
                                <button class="increase-quantity bg-blue-500 text-white px-2 py-1 rounded"
                                    data-id="{{ $id }}">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </ul>
            <div class="cart-summary">
                <strong>Total Price: <span id="total-price">£{{ number_format($totalPrice, 2) }}</span></strong>
            </div>
        </div>
    @else
        <p class="text-gray-500">Your cart is empty.</p>
    @endif
@endsection
@section('scripts')

    <script>
        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', function () {
                let bookId = this.getAttribute('data-id');
                updateQuantity(bookId, 1); // Increase quantity by 1
            });
        });

        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', function () {
                let bookId = this.getAttribute('data-id');
                updateQuantity(bookId, -1); // Decrease quantity by 1
            });
        });

        function updateQuantity(bookId, change) {

            let quantityElement = document.querySelector(`.quantity-value[data-id='${bookId}']`);
            let newQuantity = parseInt(quantityElement.innerText) + change;


            if (newQuantity < 1) {
                // Remove item if quantity is zero
                fetch(`/cart/remove/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cart-count').innerText = data.cart_count;
                        document.getElementById('total-price').innerText = `£${data.total_price}`;
                        quantityElement.closest('.cart-item').remove(); // Remove item from UI
                        if (data.cart_count === 0) {
                            document.getElementById('cart-container').innerHTML = "<p>Your cart is empty!</p>";
                        }

                    })
                    .catch(error => console.error('Error:', error));
            } else {
                // Update quantity if it's 1 or more
                fetch(`/cart/update/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        quantityElement.innerText = newQuantity; // Update UI
                        document.getElementById('cart-count').innerText = data.cart_count;
                        document.getElementById('total-price').innerText = `£${data.total_price.toFixed(2)}`;
                    })

                    .catch(error => console.error('Error:', error));
            }
        }
    </script>

@endsection