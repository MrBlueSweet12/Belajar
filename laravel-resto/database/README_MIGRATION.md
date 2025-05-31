# Laravel Resto Database Migration Guide

## Migrating to phpMyAdmin

This guide will help you import the Laravel migration files into phpMyAdmin to set up your database.

### Prerequisites

1. XAMPP installed and running
2. Apache and MySQL services started
3. Access to phpMyAdmin

### Steps to Import the Database

1. **Start XAMPP Control Panel**

    - Start Apache and MySQL services

2. **Access phpMyAdmin**

    - Open your browser and navigate to: http://localhost/phpmyadmin/

3. **Create a New Database**

    - Click on "New" in the left sidebar
    - Enter a database name (e.g., `laravel_resto`)
    - Select collation: `utf8mb4_unicode_ci`
    - Click "Create"

4. **Import the SQL File**

    - Select your newly created database from the left sidebar
    - Click on the "Import" tab at the top
    - Click "Browse" and navigate to: `C:\xampp\htdocs\laravel-resto\database\laravel_resto_migration.sql`
    - Scroll down and click "Import"

5. **Verify the Import**

    - Check that all tables have been created successfully
    - You should see the following tables:
        - users
        - password_reset_tokens
        - sessions
        - cache
        - cache_locks
        - jobs
        - job_batches
        - failed_jobs
        - personal_access_tokens
        - categories
        - customers
        - menus
        - orders
        - order_details

6. **Update Laravel Environment File**
    - Make sure your `.env` file in the Laravel project has the correct database settings:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_resto
    DB_USERNAME=root
    DB_PASSWORD=
    ```

### Troubleshooting

-   If you encounter any errors during import, check the error message in phpMyAdmin
-   Ensure MySQL service is running
-   Verify that the database name in your `.env` file matches the one you created

### Note

This SQL file was generated from Laravel migration files. It includes all the necessary tables for the Laravel Resto application with proper relationships and constraints.
