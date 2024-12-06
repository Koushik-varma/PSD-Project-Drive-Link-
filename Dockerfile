# Use an official PHP image with Apache
FROM php:8.1-apache

# Set working directory
WORKDIR /psd/www/project

# Copy all project files, including subdirectories
COPY index.php .

# Enable necessary Apache modules
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
