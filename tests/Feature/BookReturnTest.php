<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookReturnTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_can_return_a_book()
    {
        // Arrange
        $book = Book::factory()->create(['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '578014119907', 'genre' => 'Romance']);
        $user = User::factory()->create();
        $rental = Rental::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rented_at' =>  Carbon::now(),
            'due_at' =>  Carbon::now()->addWeeks(2),
            'status'  => 'rented',
        ]);

        // Act
        $response = $this->postJson('/api/books/return', [
            'rental_id' => $rental->id,
        ]);

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'returned']);
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'returned']);
    }

    public function test_it_cannot_return_a_non_existent_rental()
    {
        $response = $this->postJson('/api/books/return', [
            'rental_id' => '9999',
        ]);

        $response->assertStatus(404);
    }
}
