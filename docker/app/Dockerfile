FROM php:8.4-cli

WORKDIR /var/www/html

# # PHP で必要なライブラリをインストール
# コマンド	役割
# libzip-dev	PHP の zip 拡張をビルドするために必要なライブラリ
# libonig-dev	PHP の mbstring 拡張をビルドするために必要なライブラリ
# unzip	.zip ファイルを解凍するための Linux コマンド

# 拡張名	役割
# zip	.zip ファイルを PHP で扱えるようにする
# mbstring	マルチバイト文字（日本語など）の処理を可能にする
# bcmath	高精度の数学計算を可能にする

RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip \
    && docker-php-ext-install mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*


# # composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# # ファイルのコピー
COPY ./src /var/www/html
