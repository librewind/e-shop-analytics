Installation Instructions
==========

## Requirements

* [Docker and Docker Compose](https://docs.docker.com/engine/installation)
* [MacOS Only]: Docker Sync (run `gem install docker-sync` to install it)

## Configuration

Default configuration is stored in `.env` file (this file is added to VCS).
Local configuration can be added to `.env.local`

### HTTP port
If you have nginx or apache installed and using 80 port on host system you can either stop them before proceeding or
reconfigure Docker to use another port by changing value of `EXTERNAL_HTTP_PORT` in `.env` file.

### Application environment
You can change application environment to `dev` of `prod` by changing `APP_ENV` variable in `.env` file.

### DB name and credentials
DB name and credentials could by reconfigured by changing variables with `POSTGRES` prefix in `.env` file. It is
recommended to restart containers after changing these values (new database will be automatically created on containers
start).

## Installation

### 1. Start Containers and install dependencies
On Linux:
```bash
docker-compose up -d
```
On MacOS:
```bash
docker-sync-stack start
```
### 2. Run migrations, install fixtures
```bash
docker-compose exec php bin/console doctrine:migrations:migrate
docker-compose exec php bin/console doctrine:fixtures:load
```

### 3. Open project
Just go to [http://localhost:8001](http://localhost:8001)

Application commands
==========
Generate fact sales:
```bash
docker-compose exec -u www-data php bin/console app:generate-fact-sales --no-debug
```

Useful commands and shortcuts
==========

## Shortcuts
It is recommended to add short aliases for the following frequently used container commands:

* `docker-compose exec php php` to run php in container
* `docker-compose exec php composer` to run composer
* `docker-compose exec php bin/console` to run Symfony CLI commands
* `docker-compose exec db psql` to run PostgreSQL commands

##kafkacat

Send fact sale to queue manually:
```bash
kafkacat -b localhost:9092 -t fact_sales -P
{"date":"2019-01-01","customer_id":1,"customer_first_name":"Ivan","customer_last_name":"Ivanov","customer_date_of_birth":"1999-01-01","product_id":1,"product_sku":"ASD11DD","product_name":"IPhone","quantity":1,"net_price":999.99,"discount_price":799.99,"promotion_id":1,"promotion_name":"promo"}
```

Read messages from queue:
```bash
kafkacat -b localhost:9092 -t fact_sales
```

###Yandex Tank

Start:
```bash
docker run \
    -v $(pwd):/var/loadtest \
    -v $SSH_AUTH_SOCK:/ssh-agent -e SSH_AUTH_SOCK=/ssh-agent \
    --net host \
    -it direvius/yandex-tank
```