# Official PHP image with Apache pre-installed
FROM php:8.2-apache-bookworm

# Set the working directory inside the container
WORKDIR /var/www/laravel

# Install the PHP extensions, with them PHP can communicate with MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite, because Laravel relies on pretty URLs
RUN a2enmod rewrite

# Set Apache's document root to Laravel's public/ directory
ENV APACHE_DOCUMENT_ROOT=/var/www/laravel/public

# Update Apache config to use the new document root
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Optional: permissions (unneeded if you're using bind mounts)
RUN chown -R www-data:www-data /var/www/laravel

# Expose port 80 (default for Apache)
EXPOSE 80

# Copy local project files into the Apache server's web root
COPY ./src /var/www/laravel/
