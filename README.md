## Требования

> <ol>
>  <li>PHP 7.4</li>
>  <li>Composer</li>
> </ol>

## Установка
#### Клонировать репозиторий
> git clone https://github.com/RinseArtem/test

#### Установить зависимости
> composer install

#### В .env прописать доступ к БД
> DB_CONNECTION=mysql <br />
> DB_HOST=127.0.0.1 <br />
> DB_PORT=3306 <br />
> DB_DATABASE=test <br />
> DB_USERNAME=root <br />
> DB_PASSWORD= 

#### Провести миграции
> php artisan migrate

***
Главная доступна по адресу: ``site.ru/public/``
