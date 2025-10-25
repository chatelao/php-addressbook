# Use a community-maintained PHP 5.4 image as a parent image
FROM vulhub/php:5.4.1-apache

# Update sources.list to point to the Debian archive
RUN echo "deb http://archive.debian.org/debian/ jessie main non-free contrib" > /etc/apt/sources.list && \
    echo "deb-src http://archive.debian.org/debian/ jessie main non-free contrib" >> /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian-security/ jessie/updates main non-free contrib" >> /etc/apt/sources.list && \
    echo "deb-src http://archive.debian.org/debian-security/ jessie/updates main non-free contrib" >> /etc/apt/sources.list

# Install mysqli extension and mysql server
RUN apt-get update && apt-get install -y --allow-unauthenticated mysql-server mysql-client && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/
