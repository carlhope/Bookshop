<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookshop') }}</title>
    @vite('resources/css/app.css')

</head>

<body class="font-sans bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-purple-600 text-white p-4">
        <h1 class="text-3xl font-bold">Bookshop</h1>
    </header>

    <!-- Navigation -->
    <nav class="bg-gold-500 text-gray-900 p-3 flex items-center">
        <!-- Left Side: Home & Books -->
        <div class="flex space-x-3">
            <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
            <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
        </div>

        <!-- Right Side: View Cart -->
        <a href="{{ route('cart.view') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 ml-auto">
            View Cart (<span id="cart-count">{{ session('cart_count', 0) }}</span>)
        </a>
    </nav>

    <!-- Main Content -->
    <main class="p-6 bg-gray-200">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-purple-600 text-white text-center p-3">
        <p>&copy; {{ date('Y') }} Bookshop. All rights reserved.</p>
    </footer>
    @yield('scripts')
</body>


</html>