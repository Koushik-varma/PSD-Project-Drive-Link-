# Use the official PHP-Apache image
FROM php:8.2-apache

# Install necessary PHP extensions (pdo_mysql is required)
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose the web server port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
