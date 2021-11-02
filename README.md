# Dibbling

## 安裝所需
- docker
- docker-compose
- php:^8.0
- composer:^2.1
- node:13.7.0
- npm:6.13.6

## PHP
要先讓本機的PHP版本為 8.* 以上

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

## GOOGLE_API_KEY 設定

在有 .env 有一個 key 叫做 GOOGLE_API_KEY 可以自行使用自己的 google 帳號申請

或跟 york 借

```
GOOGLE_API_KEY = {{GOOGLE_API_KEY}}
```

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

```
php artisan db:seed
```
將所需的資料建立起來

## Log 在哪？

Nginx log: docker/nginx

Socket log: docker/node

## 關於註冊

註冊時會發現寄送認證信失敗

請再重新瀏覽首頁輸入帳號密碼即可登入
