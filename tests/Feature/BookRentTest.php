<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookRentTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_it_can_rent_a_book()
    {
        // Arrange
        $book = Book::factory()->create(['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '578014119907', 'genre' => 'Romance']);
        $user = User::factory()->create();

        // Act
        $response = $this->postJson('/api/books/rent', [
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'rented']);
        
        $this->assertDatabaseHas('rentals', [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'status'  => 'rented'
        ]);
    }

    public function test_it_cannot_rent_a_non_existent_book()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->postJson('/api/books/rent', [
            'book_id' => 9999,  // Non-existent book ID
            'user_id' => $user->id,
        ]);

        // Assert
        $response->assertStatus(422);
    }

}
