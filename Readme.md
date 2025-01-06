# Symfony REST Application

## Описание

Это Symfony REST-приложение для расчета цены продукта и проведения оплаты.

## Установка и запуск

### Клонирование репозитория

git clone https://github.com/Fortech4N9/test_systemeio.git
cd test_systemeio

## Запуск Docker

docker-compose up -d

## Установка зависимостей

docker-compose exec app composer install

## Запуск миграций

docker-compose exec app php bin/console doctrine:migrations:migrate

## Загрузка начальных данных

docker-compose exec app php bin/console doctrine:fixtures:load

## Сервер доступен по адресу http://localhost:8080

## Примеры запросов:

### Колькулятор цены:
POST http://localhost:8080/calculate-price
Content-Type: application/json

{
    "product": 1,
    "taxNumber": "DE123456789",
    "couponCode": "D15"
}

### Покупка:
POST http://localhost:8080/purchase
Content-Type: application/json

{
    "product": 1,
    "taxNumber": "IT12345678900",
    "couponCode": "D15",
    "paymentProcessor": "paypal"
}

## В файле class-diagram.png приставлена диаграмма классов проекта