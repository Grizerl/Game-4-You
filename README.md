## Game 4 You 

Game 4 You is your ultimate destination for everything gaming. Whether you're into PC, console, or mobile games – we’ve got you covered. Stay updated with the latest gaming news, explore detailed game reviews, check out trailers, and discover the hottest upcoming releases. Join our community of passionate gamers and find the perfect game just for you!

## Technologies Used

- **Laravel**: Backend framework for routing, models, controllers, and database management.
- **Blade**: Templating engine used for rendering views.
- **MySQL**: Database system for storing user and card-related data.

## Launch instructions

1. Clone the repository: `git clone https://github.com/Grizerl/Game-4-You.git`.
2. Change to the project folder: `cd game`.
3. Install the dependencies: `composer install`.
4. Set up the .env file by copying from the example: `cp .env.example .env`.
5. Configure the database connection in your .env file:
DB_CONNECTION=mysql  
DB_HOST=your_database_host  
DB_PORT=your_database_port  
DB_DATABASE=your_database_name  
DB_USERNAME=your_database_user  
DB_PASSWORD=your_database_password
6. Generate the application key: `php artisan key:generate`.
7. Run the database migrations: `php artisan migrate`.
8. Start the Laravel development server: `php artisan serve`.