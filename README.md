# ⭐ Symfony starter project ⭐

This is a basic symfony project.  
With this project you can start a fresh symfony project.

## 🚀 Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.
These instructions are made for Linux/Ubuntu users.

## 👀 Prerequisites 

You must have docker and docker compose installed :

```shell
docker -v
# Docker version 27.5.1, build 9f9e405

docker compose version  
# dDocker Compose version v2.32.4
```

## 🕥 Installing 

After forking this project and clone it from your own repo, go in your project then :
```shell
cp .env.example .env
```

Because you clone this project, please consider generating a new symfony `APP_KEY` (run `date | md5` or see http://nux.net/secret for example)  
Copy the given value into your .env

```shell
make install
```

You should now have access to : 
- [Homepage](http://localhost:8080/).  
- [Mailcatcher](http://localhost:1080/). 

If localhost doesn't work, go on 127.0.0.1 in your browser. If this ip works, then you probably have trouble into your /etc/hosts or somewhere else, please check ask google / GPT. You can also open an issue and i'll try to reproduce.

## 🔜 Next 
Take a look to the Makefile to see all amazing targets available !

*Note: The current PHP stable version is 8.4, if you want to change it, look into `Dockerfile` > `php:8.4-fpm`*

*Same for Nginx and MariaDB*

## 💥 Running the tests 

My point of view is that the first thing you can do to know if your code will break, is to use PHPStan.  
With it, you will see if something unexpected can happen. Such as returning a string when an integer is expected...

But otherwise, of course, real tests can be made with PHPUnit :
```shell
make phpstan
make phpunit
```

Before running `make phpunit` you mihght need to stop the project, in your .env change the `APP_ENV` to `testing` and restart the project.

## 💅 Coding style tests 

```shell
make php-cs-fixer 
```

## 💙 Built With

* [Symfony](https://symfony.com/) - The web framework used
* And lots of love 

## 👋 Authors

* **Damien Lebossé** - *Initial work* - [ProElbs](https://github.com/ProElbs)

## 📄 License

This project is licensed under the MIT License