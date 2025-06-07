<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Bookshop') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="font-sans bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-purple-600 text-white p-4">
        <h1 class="text-3xl font-bold">Bookshop</h1>
    </header>

    <!-- Navigation -->
    <nav class="bg-gold-500 text-gray-900 p-3">
        <a href="/" class="px-3 font-semibold hover:text-purple-200">Home</a>
        <a href="/books" class="px-3 font-semibold hover:text-purple-200">Books</a>
    </nav>

    <!-- Main Content -->
    <main class="p-6 bg-gray-200">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-purple-600 text-white text-center p-3">
        <p>&copy; {{ date('Y') }} Bookshop. All rights reserved.</p>
    </footer>
</body>


</html>