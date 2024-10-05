<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentalController;

Route::get('/books/search', [BookController::class,'search']);
Route::post('/books/rent', [RentalController::class, 'rent']);
Route::post('/books/return', [RentalController::class, 'return']);
Route::get('/rental/history', [RentalController::class, 'history']);
Route::get('/rental/overdue', [RentalController::class, 'markOverdue']);
Route::post('/send-overdue-emails', [RentalController::class, 'sendOverdueEmails']);
Route::get('/rental/stats', [RentalController::class, 'stats']);
