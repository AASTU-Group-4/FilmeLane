# Use the official PHP image with Apache
FROM php:apache

# Update and install necessary packages
RUN apt-get update && apt-get install -y libcurl4-openssl-dev

# Install PHP curl extension
RUN docker-php-ext-install curl

RUN docker-php-ext-install mysqli


# Set working directory
WORKDIR /var/www/html/
