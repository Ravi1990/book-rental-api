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
`/api/books/rent` -- Rent a book
             -- POST Paramaters
             -- `book_id`
             -- `user_id`
        
`/api/books/return` -- Return a book
             -- POST Paramaters
             -- `rental_id`

`/api/rental/history` -- Check rental history
             -- Query Paramaters
             -- `user_id`

`/api/rental/stats` -- Check rental stats
                    -- Kept it simple with basic details

`/api/rental/overdue` -- Mark overdue manual api action 
                      -- Schedule aready there but if wanted it manually from some action button

`/api/send-overdue-emails` -- Send overdue email manual api action 
                      -- Schedule aready there but if wanted it manually from some action button

`php artisan app:mark-overdue-rentals` For marking overdue manually, on server need to setup cron

`php artisan rental:send-overdue-emails` For running overdue email manually, on server need to setup cron


             

## Testing
`php artisan test`  Run the tests 