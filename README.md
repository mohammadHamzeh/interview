# Snappfood interview

## Deploy

1. git clone
2. cd interview
3. composer install --no-plugins --no-scripts
4. cp .env.example .env
5. php artisan key:generate
6. vim .env // update the variables names
7. php artisan optimize
8. php artisan migrate --seed

## Test

- Inside the project root directory type the following:
  `php artisan test`

