# cws-machine-test

## Overview

This Laravel application is a cws-machine-test. It utilizes Laravel 10, PHP 8 or later, Bootstrap 5, Ajax, and jQuery.

## Getting Started

### Downloading the Project

If you have a zipped folder, unzip it. If you're using Git, use the following command to clone the repository:

```bash
git clone https://github.com/aadilbashirbhat/cws-machine-test.git

This will create a folder named cws-machine-test.

Installing Dependencies
Navigate to the project folder:
cd cws-machine-test

Run the following commands to install the required dependencies:
composer install
npm install


Database Configuration
Make a copy of .env.example and rename it to .env. Update the following sections in the .env file with your database configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_cws-machine-test
DB_USERNAME=root
DB_PASSWORD=

Database Migration
Run the migration command to set up the database:
php artisan migrate
php artisan storage:link
Usage
Run the following command to start the development server:
php artisan serve

Access the application by visiting the provided URL in your browser. Navigate to the registration page, create an account, log in, and you'll be redirected to the new dashboard.
