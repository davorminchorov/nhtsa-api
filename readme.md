# NHTSA API 

## Installation

Install [Git](https://git-scm.com/) on your operating system.


After the installation run the following command to see if Git is installed properly:

```
git
```

Clone the project from the GitHub repository by running the following command in the terminal

```
git clone https://github.com/davorminchorov/nhtsa-api.git
```

Enter the directory with

```
cd nhtsa-api
```

Server Requirements: 

- PHP >= 7.1.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- BCMath PHP Extension
- GD PHP Extension
- Zip PHP Extension
- MCrypt PHP Extension
- MySQL (optional)
- Redis (optional)
- NGINX
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)

### Using Docker

This project has a docker development environment ready which you can easily set up the project on your local machine by installing [Docker Community Edition](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/) for the operating system you are using.

After installing Docker CE and Docker Compose, run the following commands to see if everything was installed properly:

```
docker
docker-compose
```

Run the following command to build the project:

```
docker-compose build
```

This command will install everything that the project needs.

After the build is complete, run the following command to start the docker containers:

```
docker-compose up -d
```

To enter the PHP FPM container, you need to run the following command:

```
docker exec -it nhtsaapi_phpfpm_1 bash
```


Run the following command if you want to stop the docker containers:

```
docker-compose stop
```

If you want to see the status of the docker containers, run the following command:

```
docker-compose ps
```

NOTE: Depending on the way you installed Docker CE and Docker Compose, you may need to run the `docker` and `docker-compose` commands with `sudo` as a prefix 

Install the Composer dependencies by running:

```
composer install
```

Copy the file .env.example as .env and use it as a starting point for your local development environment. You have to set it up yourself based on the environment you are using.

You can run the following command to copy the .env.example to .env:

```
cp .env.example .env
```

Run the following command to generate an application key:

```
php artisan key:generate
```

You may also need to give permissions to the `storage` folder by running:

```
chmod -R 0777 storage
```

Open the project in your browser by going to: 

```
http://localhost:8080/
```

### Without Docker

After installing everything listed from the `Server Requirements` section continue following the instructions below.

Install the Composer dependencies by running:

```
composer install
```

Copy the file .env.example as .env and use it as a starting point for your local development environment. You have to set it up yourself based on the environment you are using.

You can run the following command to copy the .env.example to .env:

```
cp .env.example .env
```

Run the following command to generate an application key:

```
php artisan key:generate
```

You may also need to give permissions to the storage folder by running:

```
chmod -R 0777 storage
```

`OPTIONAL:` You could also use the PHP built-in server which Laravel has a command by running:

```
php artisan serve --port=8080
```

Open the project in your browser by going to: 

```
http://localhost:8080/
```

## Testing

This project includes a few feature tests.

### With Docker

To run the tests, run the following command from within the PHP-FPM container:

```
./vendor/bin/phpunit
```

### Without Docker

To run the tests, run one of the following commands within the project directory depending on the terminal or operating system you are using:

```
phpunit
or
./vendor/bin/phpunit
or
./vendor/bin/phpunit.bat
or
./phpunit.bat
```