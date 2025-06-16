<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookshop') }}</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')

</head>

<body class="font-sans bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-purple-600 text-white p-4">
        <h1 class="text-3xl font-bold">Bookshop</h1>
    </header>

    <!-- Navigation -->
    <nav class="bg-gold-500 text-gray-900 p-3">
        <div class="flex justify-between items-center">
            <!-- Left Side: Logo & Links -->
            <div class="hidden md:flex space-x-3">
                <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
                <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
            </div>

            <!-- Right Side: View Cart -->
            <a href="{{ route('cart.view') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 ml-auto">
                View Cart (<span id="cart-count">{{ session('cart_count', 0) }}</span>)
            </a>

            <!-- Mobile Menu Button -->
            <button id="menu-toggle" class="md:hidden bg-gray-700 text-white px-3 py-2 rounded">
                ☰
            </button>
        </div>

        <!-- Mobile Menu (Hidden by Default) -->
        <div id="mobile-menu" class="hidden flex flex-col space-y-2 mt-2 md:hidden">
            <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
            <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
        </div>
    </nav>


    <!-- Main Content -->
    <main class="p-6 bg-gray-200">
        <!--@yield('content')-->
        @inertia
    </main>

    <!-- Footer -->
    <footer class="bg-purple-600 text-white text-center p-3">
        <p>&copy; {{ date('Y') }} Bookshop. All rights reserved.</p>
    </footer>
    @yield('scripts')
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            let mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>


</html>