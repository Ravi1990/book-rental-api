#  API for a book rental service

## Overview
API for a book rental service that allows users to search for books, rent books for a 
maximum of 2 weeks, return books, view rental history, automatically mark rentals as 
overdue, and send email notifications for overdue rentals.

## Setup Instructions
1. Clone repository
2. Install dependencies `composer install`
3. Copy `.env.example` to `.env` and configure your database.
4. Run `PHP artisan migrate --seed` to setup database
5. RUN  `PHP artisan serve` to start server


## API'S

`/api/books/search` -- Search for Books by name and or genre
             -- Query Paramaters
             -- `title`
             -- `genre`