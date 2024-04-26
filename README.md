# Pig Latin překladač

Install:

````
$ docker-compose build
$ docker-compose up -d
$ docker-compose exec php composer install
````

Run:

````
$ docker-compose exec php php bin/console app:translate
````

Složená slova lze detekovat pomocí zápisu snake_case, camelCase nebo pomocí AI.
Pro vyzkoušení AI je potřeba do souboru config/config.php vložit API pro OpenAI (Chat GPT)

Run test:

````
$ docker-compose exec php php ./vendor/bin/phpunit tests
````
