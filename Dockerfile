FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
  zip \
  unzip \
  git \
  libzip-dev \
  && docker-php-ext-install zip \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .

RUN composer install --no-interaction
RUN mkdir -p data