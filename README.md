# Dibbling

### 安裝所需
- php7.2^
- composer
- docker
- docker-compose

### composer

安裝composer

```bash
composer install
```

### .env 設定

複製一個.env 從 .env.local

### hosts 設定

```
# dibbling
127.0.0.1	local.dibbling.tw mysql
```

### laravel

```
php artisan migrate
```

### 啟動

```
bash env.sh
```
