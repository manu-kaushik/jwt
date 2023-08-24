FROM php:8.1-cli

WORKDIR /app

RUN apt update && \
    apt install -y zip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD [ "bash" ]
