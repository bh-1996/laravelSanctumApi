## Author : MBK Bhandari
# Laravel Sanctum API Project

This project demonstrates a Laravel-based API secured with Laravel Sanctum for authentication. It includes basic CRUD operations for managing posts with image uploads and deletions. The project showcases how to handle file uploads, validation, and secure API endpoints using Sanctum.

## Features

- **Authentication**: Secure authentication using Laravel Sanctum.
- **CRUD Operations**: Create, read, update, and delete posts.
- **Image Handling**: Upload and delete images associated with posts.
- **Validation**: Server-side validation for incoming requests.
- **Testing**: Includes API testing for endpoints.

## Prerequisites

- PHP 8.x
- Composer
- Laravel 10.x
- MySQL or any other supported database
- XAMPP or similar local development environment

## Installation

1. Clone the repository:
   ```bash
   git clone git@github.com:bh-1996/laravelSanctumApi.git

2. Navigate to the project directory:
    ```bash
    cd laravelSanctumApi

3. Install dependencies:
    ```bash
    composer install


4. Copy .env.example to .env and configure your environment variables:
    ```bash
    cp .env.example .env

5. Generate application key:
    ```bash
    php artisan key:generate

6. Run database migrations:
    ```bash
   php artisan migrate

7. Serve the application:
    ```bash
    cd laravelSanctumApi



## API Endpoints
- POST /api/register - Register a new user
- POST /api/login - Login and receive a token
- POST /api/logout - Logout the current user
- GET /api/posts - Retrieve all posts
- POST /api/posts - Create a new post
- GET /api/posts/{id} - Retrieve a specific post
- PUT/PATCH /api/posts/{id} - Update a specific post
- DELETE /api/posts/{id} - Delete a specific post

