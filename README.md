# t100-assessment

This project is a Laravel application called t100-assessment. This README provides the steps to set up the environment and run the project.

## Requirements

Ensure you have the following software installed on your machine:

- **PHP** (version 8.0 or higher)
- **Composer** (for PHP package management)
- **Node.js** and **npm** (for compiling assets)
- **MySQL** or another database
- **Git** (for cloning the project)

## Installation

Follow the steps below to set up the project locally.

### 1. Clone the project

Use Git to clone the project to your local machine:

`git clone https://github.com/henrik561/t100-assessment.git`

Then navigate to the project directory:

`cd t100-assessment`

### 2. Install dependencies

Install the PHP dependencies with Composer:

`composer install`

Install the front-end dependencies with npm:

`npm install`

### 3. Configure the environment file

Make a copy of the `.env.example` file and rename it to `.env`:

`cp .env.example .env`

Update the database settings in the `.env` file. For example:

```
DB_CONNECTION=mysql 
DB_HOST=127.0.0.1 
DB_PORT=3306 
DB_DATABASE=t100_assessment 
DB_USERNAME=root DB_PASSWORD=secret
```

### 4. Generate the application key

Laravel requires an application key. Generate this key with the following Artisan command:

`php artisan key:generate`

### 5. Migrate and seed the database

Migrate the database:

`php artisan migrate`

Seed the database with sample data:

`php artisan db:seed`

### 6. Compile the assets

To compile the front-end assets (CSS, JS), run the following npm command:

`npm run build`

### 7. Start the server

You can now start the built-in Laravel server:

`php artisan serve`

The application will be available at [http://localhost:8000](http://localhost:8000).

---

Good luck with using this project! If you have any questions, feel free to reach out.