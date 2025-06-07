@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Book List</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($books as $book)
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded-md">
                <h2 class="text-xl font-bold mt-2">{{ $book->title }}</h2>
                <p class="text-gray-600">{{ $book->author }}</p>
                <p class="text-sm">{{ $book->description }}</p>
                <p class="text-lg font-semibold text-green-600">${{ $book->price }}</p>
                <a href="{{ route('books.show', $book->id) }}"
                    class="mt-3 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
@endsection