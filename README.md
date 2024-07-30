# Crypto Manager

Crypto Manager is a comprehensive application designed to manage cryptocurrency portfolios. The backend is implemented using Go to handle API calls and store data into a database, while the frontend and user interactions are managed with Laravel and TypeScript.

## Features

- Fetches real-time cryptocurrency data from various APIs using Go.
- Stores cryptocurrency data into a database.
- Users can add cryptocurrencies to their portfolio.
- Displays the user's cryptocurrency portfolio on the user screen.

## Technologies Used

- **Go**: Handles API calls to fetch cryptocurrency data.
- **Laravel**: Manages the application logic and interactions.
- **TypeScript**: Ensures type safety and handles client-side logic.
- **SQLite**: Database to store cryptocurrency and user data.

## Database Schema

### Tables

#### coins
- `id` (integer, primary key)
- `rank` (integer)
- `name` (string)
- `symbol` (string)
- `icon` (string)
- `price` (float)
- `change24h` (float)
- `market_cap` (float)
- `total_volume` (float)
- `ath` (float)
- `chart_data` (text)
- `created_at` (timestamp)
- `updated_at` (timestamp)

#### coin_user
- `id` (integer, primary key)
- `user_id` (integer, foreign key references users(id))
- `coin_id` (integer, foreign key references coins(id))
- `created_at` (timestamp)
- `updated_at` (timestamp)

## Setup and Installation

### Prerequisites

- Go 1.16+
- PHP 7.4+
- Composer
- Node.js 14+
- SQLite

### Backend Setup (Go)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/pansani/crypto-laravel.git
   cd crypto-laravel
   ```

2. **Navigate to the Go directory:**
   ```bash
    cd api-go
   ```

4. **Install dependencies:**
    ```bash 
     go mod tidy
    ```
5. **Run the Go application:**
    ```bash
     go run main.go
    ```

### Frontend Setup (Laravel & TypeScript)

1. **Navigate to the root directory:**

    ```bash
    cd ..
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

4. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

5. **Start the Laravel development server:**

    ```bash
    php artisan serve
    ```

6. **Start the frontend development server:**

    ```bash
    npm run dev
    ```





