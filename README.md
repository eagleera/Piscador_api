# piscador_api

## Para instalar lo necesario para el proyecto
```
composer install
```

### Para correrlo
```
php -S localhost:8000
```
### datos que tienen que ir en el .env
```
APP_NAME=piscador_api
APP_ENV=local
APP_KEY=queondamijo
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC
CURRENT_DB=main

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nombrequequieras
DB_USERNAME=usernametuyo
DB_PASSWORD=passwordtuyo
JWT_SECRET=tujwtsecreto
```