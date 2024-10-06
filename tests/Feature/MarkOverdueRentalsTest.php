<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MarkOverdueRentalsTest extends TestCase
{
    use DatabaseTransactions;
   
    public function test_it_marks_rentals_as_overdue_if_not_returned_within_2_weeks()
    {
        // Arrange
        $book = Book::factory()->create(['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '578014119907', 'genre' => 'Romance']);
        $user = User::factory()->create();
        $rental = Rental::create([
            'book_id'   => $book->id,
            'user_id'   => $user->id,
            'status'    => 'rented',
            'rented_at' => Carbon::now()->subWeeks(3),
            'due_at' => Carbon::now()->subWeek(1),
        ]);

        // Act: Run the command to mark overdue rentals
        Artisan::call('app:mark-overdue-rentals');

        // Assert
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'status' => 'overdue'
        ]);
    }
}

