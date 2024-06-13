# metricas-PageSpeed
Through Google's PageSpeed ​​Insights API, you will be able to obtain data on the user experience of a web page

## Requisitos

- PHP 8.1.26
- Composer
- NPM
- Mysql

## Instalación

1. **Clona el repositorio:**

```bash
git clone https://github.com/francoecheverria/metricas-PageSpeed.git
```

```
cd metricas-PageSpeed
```
```
composer install
```
```
npm install
```
```
cp .env.example .env
```
```
php artisan key:generate
```
Configure el .env con lo siguiente:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=metrics
DB_USERNAME=root
DB_PASSWORD=
```
```
php artisan migrate --seed
```
```
npm run dev
```

## Uso

```
php artisan serve

```
