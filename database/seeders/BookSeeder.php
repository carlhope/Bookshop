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
    ['title' => 'The Enchanted Realm', 'author' => 'Lillian Graves', 'published_year' => 2023, 'category_id' => 1, 'description' => 'A young hero discovers a hidden kingdom beneath the earth.', 'price' => 15.99, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Nebula Rising', 'author' => 'Marcus Steele', 'published_year' => 2022, 'category_id' => 2, 'description' => 'In the year 3025, a rogue scientist fights for humanity’s survival.', 'price' => 19.99, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Shadows in the Fog', 'author' => 'Vivian Lockhart', 'published_year' => 2021, 'category_id' => 3, 'description' => 'A detective races against time to unravel a deadly conspiracy.', 'price' => 14.50, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Echoes of War', 'author' => 'Benjamin Cross', 'published_year' => 2020, 'category_id' => 4, 'description' => 'A soldier’s tale intertwined with a forgotten love story.', 'price' => 17.99, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'The Night Haunts', 'author' => 'Serena Blackwood', 'published_year' => 2023, 'category_id' => 5, 'description' => 'A cursed town, haunted by its terrifying past.', 'price' => 18.00, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'The Last Magician', 'author' => 'Alistair Rook', 'published_year' => 2022, 'category_id' => 1, 'description' => 'A lone magician fights to restore magic to the world.', 'price' => 16.25, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Into the Singularity', 'author' => 'Cassandra Wright', 'published_year' => 2021, 'category_id' => 2, 'description' => 'A scientist discovers a portal beyond space and time.', 'price' => 20.50, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Murder at Midnight', 'author' => 'Jasper Holt', 'published_year' => 2020, 'category_id' => 3, 'description' => 'A high-profile murder sends shockwaves through a quiet town.', 'price' => 13.75, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'The Emperor’s Secret', 'author' => 'Rosalind Carter', 'published_year' => 2019, 'category_id' => 4, 'description' => 'An orphan boy stumbles upon a long-lost imperial secret.', 'price' => 16.99, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Underneath the Ruins', 'author' => 'Derek Vaughan', 'published_year' => 2023, 'category_id' => 5, 'description' => 'A team of archaeologists unleashes an ancient horror.', 'price' => 19.25, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'The Glass Tower', 'author' => 'Eleanor Stratton', 'published_year' => 2022, 'category_id' => 1, 'description' => 'A princess fights for freedom in a world ruled by sorcery.', 'price' => 21.50, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
    ['title' => 'Cybernetic Uprising', 'author' => 'Nathaniel Chase', 'published_year' => 2021, 'category_id' => 2, 'description' => 'The fate of mankind hangs in the balance as AI revolts.', 'price' => 22.99, 'cover_image' => 'https://www.shutterstock.com/shutterstock/photos/2517453067/display_1500/stock-photo-png-an-open-book-isolated-on-white-background-2517453067.jpg'],
            ]);

    }
}
