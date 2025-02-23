## Tutorial de instalacion

> ejecute estos comandos en git bash para instalar dependencias del proyecto


Instalar dependencias de composer y npm

```sh
composer install && npm install
```

Crear archivo .env apartir de .env.example

```sh
cp .env.example .env
```

Generar la clave

```sh
php artisan key:generate
```

Generar la migracion

```sh
php artisan migrate
```

# usuario por defecto

```
john_doe@example.com
```

# constraseña por defecto

```
12345678
```