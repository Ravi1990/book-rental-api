<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookSearchTest extends TestCase
{
    public function test_search_books_by_title()
    {
        $response = $this->get('/api/books/search?title=1984');
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => '1984']);
    }

    public function test_search_books_by_genre()
    {
        $response = $this->get('/api/books/search?genre=Classics');
        $response->assertStatus(200);
        $response->assertJsonFragment(['genre' => 'Classics']);
    }

    public function test_it_returns_empty_if_no_books_found()
    {
        $response = $this->getJson('/api/books/search?title=NonExistent');

        $response->assertStatus(200)
                 ->assertJsonCount(0);
    }
}
