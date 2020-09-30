# Test shop application

Based on Laravel and Vue.js

## Installation


```bash
git clone git@github.com:everything-now/test-shop-application.git
```
```bash
composer install
```
```bash
yarn install
```
```bash
php artisan key:generate
```
Configure you .env file. Set data for DB connection and APP_ADMIN_EMAIL
After that

```bash
php artisan migrate
```
```bash
php artisan db:seed
```

## Testing

```bash
php artisan test
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
