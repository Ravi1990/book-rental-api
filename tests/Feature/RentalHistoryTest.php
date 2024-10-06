<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentalHistoryTest extends TestCase
{
    use DatabaseTransactions;
    public function test_it_can_view_rental_history_for_a_user()
    {
        // Arrange
        $book = Book::factory()->create(['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '578014119907', 'genre' => 'Romance']);
        $user = User::factory()->create();
        $rentalDurationWeeks = config('rental.rental_duration_weeks');
        $rental = Rental::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rented_at' =>  Carbon::now(),
            'due_at' =>  Carbon::now()->addWeeks($rentalDurationWeeks),
            'status'  => 'rented',
        ]);
        // Act
        $response = $this->getJson('/api/rental/history?user_id=' . $user->id);

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['book_id' => $book->id]);
    }

    public function test_it_returns_422_if_user_id_is_missing()
    {
        $response = $this->getJson('/api/rental/history');

        $response->assertStatus(422);
    }
}
