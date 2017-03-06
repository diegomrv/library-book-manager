# Library Book Manager

This is a little project as a challenge for Maniak.
Built in Laravel 5.4, it's a system to manage books in a Library, where Books are categorized and can be borrowed by users. Book list has filtering and pagination.

## Installation

1. Clone the repository.
2. Run ``composer install``
3. Create .env file from .env.example template
4. On .env file, change database name to "library", configure APP_URL to whatever you need
5. Run ``php artisan key:generate``to add a APP_KEY to .env file
6. Run ``php artisan migrate``
7. Run ``php artisan db:seed``

## Usage

You can log in with the test user "cosme@gmail.com", "1234" or you can register on the top nav bar. After login, you can go to the book manager.
From the main list, you can filter books, borrow them, return them or delete them. There's also a link to edit books.
From the Create Book button you can add new entries to the database.

When you're done, logout from the top nav bar.

## Credits

Diego Rodríguez.