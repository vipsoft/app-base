# Dockerfile
# Reference: https://hub.docker.com/_/php?tab=description

# Base docker image
FROM php:8.5-apache

# Install required packages
RUN apt-get update && apt-get install -y \
        geoip-database \
        unzip \
        wget \
        xvfb \
        zlib1g-dev \
        libzip-dev \
    && docker-php-ext-install zip

# Download and install composer per https://getcomposer.org/download/
ENV COMPOSER_HASH c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '${COMPOSER_HASH}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Apache vhost configuration
ENV APACHE_DOCUMENT_ROOT /var/www/application
COPY ../../ ${APACHE_DOCUMENT_ROOT}/
COPY 001-application.conf /etc/apache2/sites-available/
RUN a2enmod rewrite \
    && a2dissite 000-default default-ssl \
    && a2ensite 001-application \
    && apache2ctl restart
