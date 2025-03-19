# Movie Database

Movie Database is a web application that allows users to search for and retrieve information about various movies. This application is built using the Laravel framework.

## Features

- **Movie Search**: Users can search for movies by title.
- **Movie Details**: Displays detailed information about a movie, including synopsis, director, and release date.
- **Favorite List**: Users can add movies to their favorite list for future reference.

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/ChristLuis07/movie-database.git

    Navigate to the project directory:

cd movie-database

Install dependencies using Composer:

composer install

Copy the .env.example file to .env:

cp .env.example .env

Generate the application key:

php artisan key:generate

Configure the database settings:

Edit the .env file and update the database settings:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

Run database migrations:

php artisan migrate

Start the development server:

    php artisan serve

    The application will be available at http://localhost:8000.

Contribution

If you would like to contribute to this project, please fork the repository and submit a pull request with your changes.
License

This project is licensed under the MIT License.


Let me know if you need any modifications! 🚀

