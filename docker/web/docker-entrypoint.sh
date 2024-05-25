#!/bin/bash

php-fpm

cd /var/www/html/project/tenriku.fe
php artisan storage:link

cd storage
ln -nfs /var/www/html/project/tenriku.fe/resources/images images

/usr/sbin/httpd -D FOREGROUND