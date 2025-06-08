@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md p-6 rounded-lg">
        <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
        <p class="text-gray-600">Price: £{{ $book->price }}</p>
        <p class="text-gray-500">{{ $book->description }}</p>

        <form action="{{ route('cart.add', $book->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">Add to
                Cart</button>
        </form>
    </div>
@endsection