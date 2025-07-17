<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('books')->truncate();
        DB::table('categories')->truncate();//deletes data and resets id increment
        User::query()->delete();//delete users but maintain ids

        $this->call(CategorySeeder::class);
        $this->call(BookSeeder::class);

        //create 10 random users
         User::factory(10)->create([
             'password' => bcrypt('password')
        ]);
        //create a specific user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
