# docker build -t php-fpm-image:dev .
FROM php:8.3-apache

WORKDIR /var/www/html

LABEL name="php83-apache image"

RUN apt-get update
RUN apt-get install -y git curl zip unzip vim nano htop wget mc iputils-ping libicu-dev sudo

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN a2enmod rewrite

### COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## INSTALL Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

## COPY FILES
RUN rm /root/.bashrc
ADD docker/copy_files/.bashrc /root/.bashrc
ADD docker/copy_files/.bash_aliases /root/.bash_aliases

# Dodanie konfiguracji VirtualHost dla Apache
#COPY docker-apache/apache-config.conf /etc/apache2/sites-available/000-default.conf
#
## Ustawienie uprawnień
RUN #chown -R www-data:www-data /var/www/html
