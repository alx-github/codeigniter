FROM php:7-apache
RUN ["apt-get", "update"]
RUN ["apt-get", "install", "-y", "vim"]
RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql mbstring
RUN echo 'error_reporting = E_ALL' >> /usr/local/etc/php/conf.d/99_myconf.ini
RUN echo 'date.timezone = Asia/Tokyo' >> /usr/local/etc/php/conf.d/99_myconf.ini

RUN echo '<Directory /var/www/html/>' >> /etc/apache2/apache2.conf
RUN echo '        Options Indexes FollowSymLinks' >> /etc/apache2/apache2.conf
RUN echo '        AllowOverride All' >> /etc/apache2/apache2.conf
RUN echo '        Require all granted' >> /etc/apache2/apache2.conf
RUN echo '</Directory>' >> /etc/apache2/apache2.conf

RUN service apache2 restart
