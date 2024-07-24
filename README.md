# laravel Test Api with Sanctum token
Laravel Sanctum API Project This project demonstrates a Laravel-based API secured with Laravel Sanctum for authentication. It includes basic CRUD operations for managing posts with image uploads and deletions. The project is designed to showcase how to handle file uploads, validation, and secure API endpoints using Sanctum.


## Laravel Sanctum API Project
*This project demonstrates a Laravel-based API secured with Laravel Sanctum for authentication. It includes basic CRUD operations for managing posts with image uploads and deletions. The project is designed to showcase how to handle file uploads, validation, and secure API endpoints using Sanctum.*

# Features
- Authentication: Secure authentication using Laravel Sanctum.
- CRUD Operations: Create, read, update, and delete posts.
- Image Handling: Upload and delete images associated with posts.
- Validation: Server-side validation for incoming requests.
- Testing: Includes API testing for endpoints.
## Prerequisites
- PHP 8.x
- Composer
- Laravel 9.x or 10.x
MySQL or any other supported database
XAMPP or similar local development environment
Installation
- Clone the repository: git clone git@github.com:bh-1996/laravelSanctumApi.git
- Navigate to the project directory: cd laravelSanctumApi
- Install dependencies: composer install



## API Endpoints
POST /api/register - Register a new user
POST /api/login - Login and receive a token
POST /api/logout - Logout the current user
GET /api/posts - Retrieve all posts
POST /api/posts - Create a new post
GET /api/posts/{id} - Retrieve a specific post
PUT/PATCH /api/posts/{id} - Update a specific post
DELETE /api/posts/{id} - Delete a specific post