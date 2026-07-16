FROM dunglas/frankenphp

WORKDIR /app

COPY . .

RUN install-php-extensions pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]