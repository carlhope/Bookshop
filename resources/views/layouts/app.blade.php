<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookshop') }}</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @inertiaHead



</head>

<body class="font-sans bg-gray-100 text-gray-800">


    <!-- Header -->
    <header class="bg-purple-600 text-white p-4">
        <h1 class="text-3xl font-bold">Bookshop</h1>
    </header>

    <!-- Navigation -->
    <nav class="bg-gold-500 text-gray-900 p-3">
        <div class="flex justify-between items-center">
            <div class="hidden md:flex space-x-3">
                <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
                <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
                <a href="/createbook" class="px-3 font-semibold hover:text-purple-200">Create Book</a>
            </div>
            <div class="flex space-x-3">
                @auth
                        <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Logout ({{ Auth::user()->name }})
                    </button>
                    </form>
                @endauth

                @guest
                        <a href="{{ route('login') }}" class="px-3 font-semibold hover:text-purple-200">Login</a>
                    <a href="{{ route('register') }}" class="px-3 font-semibold hover:text-purple-200">Register</a>
                @endguest
                </div> <a href="{{ route('cart.view') }}"
                    class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 ml-auto">
                View Cart <span id="cart_count"></span>
                </a>
            </div>
            <button id="menu-toggle"
                class="md:hidden flex flex-col items-center justify-center w-10 h-10 rounded bg-gray-600">
                <span class="block w-6 h-0.5 bg-white mb-1"></span>
                <span class="block w-6 h-0.5 bg-white mb-1"></span>
                <span class="block w-6 h-0.5 bg-white"></span>
            </button>
            <div id="mobile-menu" class="hidden flex flex-col space-y-3 md:hidden">
                <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
                <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
                <a href="/createbook" class="px-3 font-semibold hover:text-purple-200">Create Book</a>
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
    document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    if (menuToggle && mobileMenu) {
    menuToggle.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
    });
    }
    });
    </script>
</body>


</html>