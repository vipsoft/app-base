# Dockerfile
# Reference: https://hub.docker.com/_/php?tab=description

# Base docker image
FROM php:8.1-apache

# Install required packages
RUN apt-get update && apt-get install -y \
        geoip-database \
        unzip \
        wget \
        xvfb \
        zlib1g-dev \
    && docker-php-ext-install zip

# Download and install composer per https://getcomposer.org/download/
ENV COMPOSER_HASH 906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8
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
    && systemctl restart apache2
