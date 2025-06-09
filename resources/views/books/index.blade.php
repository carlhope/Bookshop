@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Book List</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($books as $book)
            <div class="book-card bg-white shadow-md p-4 rounded-lg flex flex-col items-center w-full max-w-sm">
                <!-- Book Image -->
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                    class="w-24 h-32 object-cover rounded">

                <!-- Book Details -->
                <div class="flex-1">
                    <h3 class="text-lg font-bold">{{ $book->title }}</h3>
                    <p class="text-gray-600">Author: {{ $book->author }}</p>
                    <p class="text-gray-600">Price: £{{ $book->price }}</p>

                    @php
                        $cart = session('cart', []);
                        $inCart = isset($cart[$book->id]);
                    @endphp

                    <!-- Button Container -->
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="cart-controls">
                            @if (!$inCart)
                                <!-- Show Add to Cart Button if not in cart -->
                                <button class="add-to-cart bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                    data-id="{{ $book->id }}">
                                    Add to Cart
                                </button>
                            @else
                                <!-- Show Quantity Controls if item is in cart -->
                                <div class="flex items-center space-x-2">
                                    <button class="decrease-quantity bg-red-500 text-white px-2 py-1 rounded"
                                        data-id="{{ $book->id }}">−</button>
                                    <span class="quantity-value text-lg font-bold w-8 text-center"
                                        data-id="{{ $book->id }}">{{ $cart[$book->id]['quantity'] }}</span>
                                    <button class="increase-quantity bg-blue-500 text-white px-2 py-1 rounded"
                                        data-id="{{ $book->id }}">+</button>
                                </div>
                            @endif
                        </div>

                        <!-- View Details Button (Always Stays to the Right) -->
                        <a href="{{ route('books.show', $book->id) }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 whitespace-nowrap">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection
@section('scripts')

    <script>
        function attachAddToCartHandler() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function () {
                    let bookId = this.getAttribute('data-id');

                    fetch(`/cart/add/${bookId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                            document.getElementById('cart-count').innerText = data.cart_count;

                            // Replace only the cart button, keeping "View Details"
                            let cartButtonContainer = this.closest('.cart-controls');
                            cartButtonContainer.innerHTML = `
                                                                    <div class="flex items-center space-x-2">
                                                                        <button class="decrease-quantity bg-red-500 text-white px-2 py-1 rounded" data-id="${bookId}">−</button>
                                                                        <span class="quantity-value text-lg font-bold w-8 text-center" data-id="${bookId}">1</span>
                                                                        <button class="increase-quantity bg-blue-500 text-white px-2 py-1 rounded" data-id="${bookId}">+</button>
                                                                    </div>
                                                                `;
                            attachQuantityHandlers(); // Rebind event listeners
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        }

        function attachQuantityHandlers() {
            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function () {
                    let bookId = this.getAttribute('data-id');
                    updateQuantity(bookId, 1);
                });
            });

            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function () {
                    let bookId = this.getAttribute('data-id');
                    updateQuantity(bookId, -1);
                });
            });
        }

        function updateQuantity(bookId, change) {
            let quantityElement = document.querySelector(`.quantity-value[data-id='${bookId}']`);
            let newQuantity = parseInt(quantityElement.innerText) + change;

            if (newQuantity < 1) {
                fetch(`/cart/remove/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                        document.getElementById('cart-count').innerText = data.cart_count;

                        // Restore "Add to Cart" button without removing "View Details"
                        let cartButtonContainer = quantityElement.closest('.cart-controls');
                        cartButtonContainer.innerHTML = `
                                                                <button class="add-to-cart bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" data-id="${bookId}">
                                                                    Add to Cart
                                                                </button>
                                                            `;
                        attachAddToCartHandler(); // Rebind event listener
                    })
                    .catch(error => console.error('Error:', error));
            } else {
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
                        quantityElement.innerText = newQuantity;
                        document.getElementById('cart-count').innerText = data.cart_count;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        attachQuantityHandlers();
        attachAddToCartHandler();
    </script>
@endsection