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

# Define a build argument
ARG USER_NAME=system

### Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

## create new user
RUN useradd -m -s /bin/bash $USER_NAME && \
    usermod -aG sudo $USER_NAME

# Allow user to run sudo without a password
RUN echo "$USER_NAME ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Copy files
RUN rm /home/$USER_NAME/.bashrc
ADD docker/copy_files/.bashrc /home/$USER_NAME/.bashrc
ADD docker/copy_files/.bash_aliases /home/$USER_NAME/.bash_aliases

# Optional(?) VirtualHost configuration for Apache
#COPY docker-apache/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Set permissions for the working directory
RUN chown -R $USER_NAME:$USER_NAME /var/www/html
RUN chown -R $USER_NAME:$USER_NAME /home/system

# Switch to the new user
USER $USER_NAME
