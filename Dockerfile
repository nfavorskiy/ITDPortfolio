FROM php:8.2-apache

# Install mysqli extension, with it PHP can communicate with MySQL
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite, because Laravel relies on pretty URLs
RUN a2enmod rewrite

# Copy local project files into the Apache server's web root
COPY ./src /var/www/html/