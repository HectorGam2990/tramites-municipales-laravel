# Trámites Municipales (Laravel)

Sistema web para gestionar ciudadanos, tipos de trámite y trámites municipales con estatus y seguimiento. Incluye autenticación y un panel administrativo sencillo.

Este repositorio está pensado principalmente para revisión de código (portafolio). No requiere demo pública para evaluarlo.

## Funcionalidades
- CRUD de ciudadanos.
- CRUD de tipos de trámite.
- CRUD de trámites con folio secuencial y estatus.
- Cambio rápido de estatus desde la tabla.
- Autenticación con Laravel Breeze.

## Stack
- Laravel 12
- PHP 8.2+
- MySQL o SQLite
- Vite
- Bootstrap 5 (panel) + Tailwind (auth de Breeze)

## Requisitos
- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- MySQL o SQLite

## Instalación rápida (SQLite)
1. Abre una terminal en la raíz del proyecto.
2. Instala dependencias PHP.
```bash
composer install
```
3. Crea el archivo de base de datos.
```bash
type NUL > database/database.sqlite
```
4. Crea un archivo `.env` con este contenido mínimo:
```env
APP_NAME="Trámites Municipales"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```
5. Genera la key y corre migraciones.
```bash
php artisan key:generate
php artisan migrate
```
6. Instala dependencias frontend y levanta Vite.
```bash
npm install
npm run dev
```
7. En otra terminal, levanta el servidor.
```bash
php artisan serve
```
8. Abre `http://127.0.0.1:8000`.

## Instalación (MySQL)
1. Instala dependencias PHP.
```bash
composer install
```
2. Crea el archivo `.env` con este contenido mínimo (ajusta tus credenciales):
```env
APP_NAME="Trámites Municipales"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tramites_municipales
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```
3. Genera la key y corre migraciones.
```bash
php artisan key:generate
php artisan migrate
```
4. Instala dependencias frontend y levanta Vite.
```bash
npm install
npm run dev
```
5. En otra terminal, levanta el servidor.
```bash
php artisan serve
```

## Scripts útiles
- `php artisan migrate:fresh --seed` para reiniciar la BD.
- `npm run build` para compilar assets.
- `php artisan test` para correr tests.

## Notas
- Las pantallas principales usan Bootstrap 5; el módulo de auth usa Tailwind (Breeze).
- Para acceder al panel necesitas crear un usuario en `/register`.
