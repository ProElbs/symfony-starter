# Symfony starter project

This is a basic symfony project.  
With this project you can start a fresh symfony project.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.
These instructions are made for Linux/Ubuntu users.

### Prerequisites

In your `~/.bashrc` you need to have:

```
export UID
export GID=$(id -g)
```

_Don't forget to run `source ~/.bashrc` after editing it._  
_Then you can verify `echo $UID` & `echo $GID`. Those commands should give you `1000` if you are the new user on your Ubuntu system_
If you don't see `1000` but for example `1001` then modify in the `docker-compose.yml` the lines `user: 1000:1000` by replacing the number.

You must have docker and docker-compose installed :

```shell
docker -v
# Docker version 24.0.2, build cb74dfc

docker-compose -v
# docker-compose version 1.29.1, build c34c88b2
```

### Installing

After forking this project and clone it from your own repo, go in your project then :
```shell
cp .env.example .env
```

Because you clone this project, it is better [to generate](http://nux.net/secret) a new symfony `APP_KEY`.  
Copy the given value into your .env

```shell
make install
```

You should now have access to the [Homepage](http://localhost/).  
Take a look to the Makefile to see all amazing targets available !

*Note: The current PHP stable version is 8.2.7, if you want to change it, look into Dockerfile > php:8.2.7-fpm*

## Running the tests

My point of view is that the first thing you can do to know if your code will break, is to use PHPStan.  
With it, you will see if something unexpected can happen. Such as returning a string when an integer is expected...

But otherwise, of course, real tests can be made with PHPUnit :
```shell
make phpstan
make phpunit
```

Before running `make phpunit` stop the project, in your .env change the `APP_ENV` to `testing` and restart the project.

### And coding style tests

```shell
make php-cs-fixer
```

[Guidelines](https://spatie.be/guidelines/laravel-php)

## Built With

* [Symfony](https://symfony.com/) - The web framework used

## Authors

* **Damien Lebossé** - *Initial work* - [ProElbs](https://github.com/ProElbs)

## License

This project is licensed under the MIT License

## Version
v1.0