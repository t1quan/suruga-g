FROM almalinux

#実行コマンドを書いていく
RUN dnf install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN dnf install -y https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf module enable php:remi-8.1 -y
RUN dnf install -y httpd
RUN dnf install -y php php-devel php-pdo php-mbstring php-pear php-pecl-apc-devel zlib-devel
RUN mkdir /run/php-fpm/

# 不要なconfigを読み込まないようにしておく
RUN mv -i /etc/httpd/conf.d/autoindex.conf /etc/httpd/conf.d/autoindex.conf.org
RUN mv -i /etc/httpd/conf.d/userdir.conf /etc/httpd/conf.d/userdir.conf.org
RUN mv -i /etc/httpd/conf.d/welcome.conf /etc/httpd/conf.d/welcome.conf.org
RUN mv -i /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.org

COPY ./docker/web/httpd.conf /etc/httpd/conf/httpd.conf

RUN mkdir /var/www/html/json_cache \
 && chmod 777 /var/www/html/json_cache

RUN mkdir /var/www/html/tp \
 && cd /var/www/html/tp \
 && ln -s /var/www/html/project/tenriku.fe/public tenriku.fe

#実行ファイルを準備 \
COPY ./docker/web/docker-entrypoint.sh /tmp

RUN mv /tmp/docker-entrypoint.sh /usr/local/bin \
 && chmod +x /usr/local/bin/docker-entrypoint.sh

#実行
ENTRYPOINT ["docker-entrypoint.sh"]