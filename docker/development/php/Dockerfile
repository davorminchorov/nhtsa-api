FROM php:7.1-fpm

COPY php.ini /usr/local/etc/php/

# Install modules
RUN apt-get update

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        libmcrypt-dev \
        curl \
        git

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

ENV TERM xterm
RUN curl -sL https://deb.nodesource.com/setup_9.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g yarn

# Possible values for docker-php-ext-install:
# bcmath bz2 calendar ctype curl dba dom enchant exif fileinfo filter ftp gd
# gettext gmp hash iconv imap interbase intl json ldap mbstring mcrypt mssql
# mysql mysqli oci8 odbc opcache pcntl pdo pdo_dblib pdo_firebird pdo_mysql
# pdo_oci pdo_odbc pdo_pgsql pdo_sqlite pgsql phar posix pspell readline recode
# reflection session shmop simplexml snmp soap sockets spl standard sybase_ct sysvmsg
# sysvsem sysvshm tidy tokenizer wddx xml xmlreader xmlrpc xmlwriter xsl zip
