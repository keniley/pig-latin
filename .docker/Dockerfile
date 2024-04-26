FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Umožnění přístupu do kontejneru (interaktivní shell)
CMD ["php", "-a"]