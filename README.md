<p align="left"><a href="https://ten.1049.cc" target="_blank"><img src="https://www.1049.cc/wp-content/uploads/svg_tenriku_logo.svg" width="400"></a></p>

## Introduction
以下のものがPCにインストールされていて、Pathが通っていることが前提となります。
- PHP8.1
- Node 16.14.2
- NPM 8.5.0

## Usage

Main
```bash
$ git clone git@gitsrv01.sys.sougo-staff.co.jp:tenichi/tenriku.fe.git
$ cd tenriku.fe
$ php composer.phar install
$ php artisan key:generate
$ php artisan serve
```

Vite
```bash
# setup
$ npm install
# develop
$ npm run dev
# production
$ npm run build
```

Docker

```bash
# local console
$ docker-compose build --no-cache
$ docker-compose up -d
$ docker-compose exec tenrikufe_web bash

# container linux
$ php-fpm
```

## Container structure

```bash
├── web # almalinux + httpd + php
└── postgres # corp_admin_db 参照
```

### web container

- Base image
    - [php](https://hub.docker.com/_/php) :8.1-fpm

### db container

- Base image
    - [pgsql](https://hub.docker.com/_/postgres) :14.5

