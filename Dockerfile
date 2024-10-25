# Use the official PHP image from the Docker Hub
FROM php:8.1-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY . .

# Install any necessary PHP extensions
RUN docker-php-ext-install mysqli

# Expose port 80
EXPOSE 80

