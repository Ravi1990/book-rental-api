<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'isbn' => '9780743273565', 'genre' => 'Classics'],
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'isbn' => '9780060935467', 'genre' => 'Classics'],
            ['title' => '1984', 'author' => 'George Orwell', 'isbn' => '9780451524935', 'genre' => 'Dystopian'],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '9780141199078', 'genre' => 'Romance'],
        ]);
    }
}
