#
# PHP Dependencies
#
FROM shippingdocker/php-composer:latest as vendor
WORKDIR /app

RUN composer global require hirak/prestissimo

#
# Application
#
FROM php:7.2-apache-stretch

RUN apt-get update && apt-get install -y \
    imagemagick \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libxslt-dev \
    vim \
    wget \
    unzip \
    git \
    libbz2-dev \
    zlib1g-dev \
    libssh2-1-dev \
    ssmtp \
    gnupg2 \
    iproute \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install -j$(nproc) zip iconv intl xml soap opcache pdo pdo_mysql mysqli mbstring bz2 exif xsl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug

# install node js
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash
RUN apt-get update && apt-get install -y nodejs

# install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update -y && apt-get install -y yarn

ENTRYPOINT ["entrypoint"]

RUN echo "ServerName $(/sbin/ip route|awk '/default/ { print $3 }')" >> /etc/apache2/apache2.conf
RUN echo 'alias ll="ls -la"' >> /root/.bashrc

COPY docker/application/disable-xdebug.sh /disable-xdebug.sh
COPY docker/application/enable-xdebug.sh /enable-xdebug.sh
COPY docker/application/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /disable-xdebug.sh /enable-xdebug.sh /usr/local/bin/entrypoint

# configure php.ini settings
COPY docker/application/php-config.ini /usr/local/etc/php/conf.d/php-config.ini

COPY docker/application/application.conf /etc/apache2/sites-available/application.conf
RUN a2dissite 000-default.conf && a2ensite application.conf && a2enmod rewrite

COPY --from=vendor /usr/bin/composer /usr/bin/composer
CMD ["apache2-foreground"]

