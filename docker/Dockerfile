# docker build -t php-fpm-image:dev .
FROM php:8.2-fpm

WORKDIR /var/www/html

LABEL name="php-fpm image" \
	desctiption="Docker Image for satelite-list project" \
	version="0.1"

RUN apt-get update
RUN apt-get install -y git curl zip unzip vim nano htop wget mc iputils-ping libicu-dev

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

## COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

## INSTALL Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

## COPY FILES
RUN rm /root/.bashrc
ADD docker/copy_files/.bashrc /root/.bashrc
ADD docker/copy_files/.bash_aliases /root/.bash_aliases

