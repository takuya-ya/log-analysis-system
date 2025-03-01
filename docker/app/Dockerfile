FROM php:8.4-cli

WORKDIR /var/www/html

# PHP で必要なライブラリをインストール
RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip \
    && docker-php-ext-install mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*


# # composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# # ファイルのコピー
COPY ./src /var/www/html

CMD [ "tail", "-f", "/dev/null" ]
