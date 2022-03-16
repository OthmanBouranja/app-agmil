# https://hub.docker.com/_/php/
FROM php:7.1.0-apache

RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

RUN apt-get install -y \
        libxml2-dev

RUN /usr/local/bin/docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get install libssl-dev -y

RUN apt-get install vim -y




RUN a2enmod rewrite
RUN usermod -u 1000 www-data
RUN usermod -G staff www-data
# #############################################################################
# Install packages and libraries
# #############################################################################



#    && php -r "unlink('composer-setup.php');"

ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf


# #############################################################################
# Create folders needed by aswak
# #############################################################################
#COPY web/var/www /opt/hosting/run/aswak/current
VOLUME /opt/hosting/run/wms/current
WORKDIR /opt/hosting/run/wms/current

RUN    mkdir -p /etc/opt/hosting/run/wms/etc \
    && mkdir -p /var/opt/hosting/log/wms \
    && mkdir -p /var/opt/hosting/cache/wms \
    && mkdir -p /var/opt/hosting/tmp/wms \
    && mkdir -p /var/opt/hosting/data/wms \
    && chown -R www-data:www-data /opt/hosting/run/wms/current
# https://hub.docker.com/r/pfcarrier/debian-locale/builds/biksnydxmevjscmbkbclu6c/


#active xdebug
#RUN echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
RUN BEFORE_PWD=$(pwd) \
    && mkdir -p /opt/xdebug \
    && cd /opt/xdebug \
    && curl -k -L https://github.com/xdebug/xdebug/archive/XDEBUG_2_5_5.tar.gz | tar zx \
    && cd xdebug-XDEBUG_2_5_5 \
    && phpize \
    && ./configure --enable-xdebug \
    && make clean \
    && sed -i 's/-O2/-O0/g' Makefile \
    && make \
    # && make test \
    && make install \
    && cd "${BEFORE_PWD}" \
    && rm -r /opt/xdebug
#RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug && \
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/20-xdebug.ini && \
    # Docker0 gateway IP address
    echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/20-xdebug.ini