# docker build -t report-gen .
# docker run --name repgen -dp 8080:8080 report-gen -v
# docker exec -ti repgen sh

FROM php:7.4-fpm
WORKDIR /app

RUN apt-get update && \
     apt-get install -y \
         curl \
         git \
         libpng-dev \
         unzip \
         libzip-dev \
         zip \
         && docker-php-ext-install zip

RUN apt-get update && \
     apt-get install -y \
         libpng-dev \
         && docker-php-ext-install gd

RUN apt-get update && \
     apt-get install -y \
         libxslt-dev \
         && docker-php-ext-install xsl

COPY . .

EXPOSE 8080