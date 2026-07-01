# フリマアプリ

## 環境構築

- git clone git@github.com:yume0606/test-marketplace-app.git

## Laravel環境構築

- cd laravel
- cp .env.example .env

.envを以下のように編集する

- DB_HOST=mysql
- DB_USERNAME=sail
- DB_PASSWORD=password

- docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
  laravelsail/php82-composer:latest \
  composer install
- ./vendor/bin/sail up -d
- ./vendor/bin/sail artisan key:generate
- ./vendor/bin/sail artisan migrate --seed

## .envのDB設定

- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=sail
- DB_PASSWORD=password

## .envのメール認証設定

- MAIL_MAILER=smtp
- MAIL_HOST=mailpit
- MAIL_PORT=1025
- MAIL_USERNAME=null
- MAIL_PASSWORD=null
- MAIL_ENCRYPTION=null
- MAIL_FROM_ADDRESS="hello@example.com"
- MAIL_FROM_NAME="${APP_NAME}"

## 使用技術

- PHP 8.5
- Laravel 10.x
- Laravel Sail
- Laravel Fortify(認証・メール認証)
- MySQL 8.4
- Mailpit(メール送信確認)

## ER図

![ER図](フリマアプリER図.png)

## URL

- 会員登録画面：http://localhost/register
- ログイン画面：http://localhost/login
- 商品一覧画面：http://localhost/
- 商品詳細画面：http://localhost/item/{item}
- 商品コメント機能：http://localhost/item/{item}/comment
- 商品購入画面：http://localhost/purchase/{item}
- 送付先住所変更画面：http://localhost/purchase/address/{item}
- プロフィール画面：http://localhost/mypage
- プロフィール編集画面：http://localhost/mypage/profile
- 商品出品画面：http://localhost/sell
- いいね機能：http://localhost/items/{item}/like
- メール認証誘導画面：http://localhost/email/verify
- メール認証：http://localhost/email/verify/{id}/{hash}

## ダミーデータでログインする場合

- メールアドレス：test@test.com
- パスワード：password

## phpMyAdmin

- http://localhost:8080
