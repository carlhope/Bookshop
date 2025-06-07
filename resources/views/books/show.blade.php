@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">
        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-64 object-cover rounded-md">
        <h1 class="text-2xl font-bold mt-4">{{ $book->title }}</h1>
        <p class="text-lg text-gray-600">{{ $book->author }}</p>
        <p class="text-sm mt-2">{{ $book->description }}</p>
        <p class="text-lg font-semibold text-green-600 mt-2">${{ $book->price }}</p>
        <button class="mt-4 bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
            Buy Now
        </button>
    </div>
@endsection