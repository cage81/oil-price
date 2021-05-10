# oil-price
Laravel application exercise to get oil price trend between two dates.

You can download the whole project and run it on your machine using [Docker](https://www.docker.com/) (you must have [Docker Desktop](https://www.docker.com/get-started) installed).

This app was developed using [Laravel Sail](https://laravel.com/docs/8.x/sail): _a light-weight command-line interface for interacting with Laravel's default Docker development environment._

## First run in a shell:

```javascript
./sail build
```

This will download two Docker images, give it the time :grin:

## then:

```javascript
./sail up -d
```

The Dockerfile(s) contained in the docker folder refers to two PHP version (7.4 and 8.0), the docker-compose here uses the 7.4 version. Once you built the image and run it, the container is accessible to the following URL:

```javascript
http://localhost:8084/
```

there is a standard [Laravel](https://laravel.com/) welcome page.

Once the containers are started, informations provided by the URI:

```javascript
https://datahub.io/core/oil-prices/r/brent-daily.json
```

are downloaded and stored in a [MySql](https://www.mysql.com/) database (a container with only one table which contains the information, it's truncated and populated at container restart through a custom [Artisan Command](#artisan-command)).

The only one RPC method you can call is the following:

```javascript
http://localhost:8084/api/v1
```

providing in input the method name and two ISO 8601 dates as the following example:

```javascript
    {
        "jsonrpc":"2.0",
        "method":"GetOilPriceTrend",
        "id":1,
        "params": { 
            "startDateISO8601":"2020-06-01",
            "endDateISO8601":"2020-07-31"
        }
    }
```

## Artisan Command

You can truncate the table and reload the informations in it running the following Artisan Command:

```javascript
./sail php artisan buzzoole:loadoilprices
```

