@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md p-6 rounded-lg flex flex-col md:flex-row items-center gap-6">

        <!-- Book Image -->
        <div class="flex-1 flex justify-center">
            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-72 h-auto object-cover rounded">
        </div>

        <!-- Book Details -->
        <div class="flex-1 flex flex-col gap-y-4">
            <h2 class="text-3xl font-bold">{{ $book->title }}</h2>
            <p class="text-gray-600 text-lg">Author: {{ $book->author }}</p>
            <p class="text-gray-600">Published Year: {{ $book->published_year }}</p>
            <p class="text-gray-600">Category: {{ $book->category->name ?? 'Uncategorized' }}</p>
            <p class="text-gray-600">Price: £{{ $book->price }}</p>
            <p class="text-gray-700">{{ $book->description }}</p>

            <!-- Cart Controls -->
            <div class="cart-controls">
                @php
                    $cart = session('cart', []);
                    $inCart = isset($cart[$book->id]);
                @endphp

                @if (!$inCart)
                    <button class="add-to-cart bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        data-id="{{ $book->id }}">
                        Add to Cart
                    </button>
                @else
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
        </div>

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

                            // Replace only the cart button, keeping other details
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

                        // Restore "Add to Cart" button without removing other details
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