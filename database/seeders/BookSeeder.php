<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            ['title' => 'Laravel for Beginners', 'author' => 'Jane Doe', 'published_year' => 2021, 'category_id' => 1, 'description'=> 'A beginner friendly guide to Laravel.', 'price'=>18.98, 'cover_image'=>'images/laravel.jpg'],
            ['title' => 'Mastering PHP', 'author' => 'John Smith', 'published_year' => 2019, 'category_id' => 2, 'description'=> 'A beginner friendly guide to Laravel.', 'price'=>18.98, 'cover_image'=>'images/laravel.jpg'],
            ['title' => 'Building Scalable Apps', 'author' => 'Emily Johnson', 'published_year' => 2022, 'category_id' => 1, 'description'=> 'A beginner friendly guide to Laravel.', 'price'=>18.98, 'cover_image'=>'images/laravel.jpg'],
        ]);

    }
}
