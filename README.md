# interview

## Deploy
1. git clone https://github.com/mohammadHamzeh/interview.git
2. cd interview
3. composer install --no-plugins --no-scripts
4. cp .env.example .env
5. php artisan key:generate
6. vim .env // update the variables names
7. docker-compose up
8. sail artisan optimize
9. sail artisan migrate --seed

## Test

- Inside the project root directory type the following:
  `sail artisan test`

## APIs

#### Version

request:
```shell
curl -X GET http://127.0.0.1:8000/version \
  -H 'Content-Type: application/json'
```

response:
```json
{
    "tag":"",
    "commit":"",
    "date":"",
    "service":"interview"
}
```