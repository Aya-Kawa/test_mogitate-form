## アプリ名
mogitate

## 環境構築

本アプリケーションは Docker を使用して構築しています。

## 使用技術（実行環境）
* git clone git@github.com:Aya-Kawa/test_mogitate-form.git
* cd test_contact-form
* docker-compose up -d --build

## Laravel環境構築
* docker-compose exec php bash
* composer install
*cp .env.example .env
*php artisan key:generate
*php artisan migrate
*php artisan db:seed
※ .env は必要に応じて DB 設定を調整してください。

## 開発環境URL
商品一覧画面：http://localhost/products
商品登録画面：http://localhost/products/register


## 使用技術（実行環境）
PHP 8.1
Laravel 8.75
MySQL
nginx
Docker / Docker Compose

## ER図
![ER図](images/ER.png)




# test_mogitate-form
