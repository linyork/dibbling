# Dibbling

## 安裝所需
- docker
- docker-compose
- php:^7.3.6
- composer:^1.9.2
- node:13.7.0
- npm:6.13.6

## composer

安裝composer

```bash
composer install
```

## npm

```bash
npm install
```

## .env 設定

複製一個.env 從 .env.local

## hosts 設定

```
# dibbling
127.0.0.1   local.dibbling.tw mysql
```

## 啟動

```
bash env.sh
```
依照指示 a. 啟動專案

## laravel

```
php artisan migrate
```
將所需的DB建立起來
