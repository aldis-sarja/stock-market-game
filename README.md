# Stock Market Game
Simple Hacker News fetcher and viewer.
Built with PHP, composer and Laravel 8. 

## Installation
```bash
git clone
cd stock-market-game
composer install
```
Copy the file `.env.demo` to `.env` and configure your database:
```bash
DB_CONNECTION=<your db server (mysql)>
DB_HOST=<db address>
DB_PORT=<db port number>
DB_DATABASE=<project db name>
DB_USERNAME=<your db user name>
DB_PASSWORD=<your password>
```

Go to `https://finnhub.io/` and get your API key. Write down that API key in `.env` file:
```bash
FINNHUB_API_KEY=<your API key>
```

Now initialize database and fetch stock data from finnhub server
```bash
php artisan migrate
php artisan queue:work &
php artisan app:first-run
```

The `app:first-run` command can take a very very long time (a couple of hours), but despite that,
you already can open another terminal, cd to stock-market-game project directory,
enter the command `php artisan serve` and open the address `http://localhost:8000/` in your web browser.
If you did stop previously launched commands, then run again  `php artisan queue:work`.
This is essential for updating stock data. 

## Usage

