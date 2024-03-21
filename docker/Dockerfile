FROM php:8.3-apache
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y git && apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer 
EXPOSE 	80
