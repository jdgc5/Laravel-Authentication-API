# Laravel Authentication API
This Laravel application demonstrates user authentication using APIs with bearer token authentication.

## Features
- User registration
- User login
- User logout
- Accessing protected routes using bearer token

## Setup
- Clone the repository
- Install dependencies
- composer install
- Create a copy of the .env.example file and rename it to .env. Update the database credentials in the .env file.
- Generate application key: php artisan key:generate
- Run migrations and seed the database: php artisan migrate --seed
- Generate JWT secret key: php artisan jwt:secret

## Usage

php artisan serve
Make API requests using tools like Postman or cURL:

User Registration:

Send a POST request to /api/register with name, email, and password fields.

User Login:

Send a POST request to /api/login with email and password fields. Upon successful login, the API will return a JWT token.

Access Protected Routes:

Include the JWT token in the request header with the key Authorization and value Bearer <token>. Now you can access the protected routes.

User Logout:

Send a POST request to /api/logout. This will invalidate the user's JWT token.

## Routes
POST /api/register: Register a new user.
POST /api/login: Login an existing user and get a JWT token.
POST /api/logout: Logout the authenticated user.

## Credits
This project is built using Laravel by J.David Garcia Corzo.
