# Ecommerce Nails — Jessica Nails Studio

App Laravel para gestión y exhibición del salón de uñas. Incluye panel admin (Filament), galería de fotos y configuración del sitio.

## Stack

- Laravel 11 + Filament
- MySQL 8.4
- Docker

## Variables de entorno

Copia `.env.example` como `.env` y completa:

```
APP_KEY=               # php artisan key:generate
APP_URL=               # URL del sitio
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
NAILS_ADMIN_EMAIL=
NAILS_ADMIN_PASSWORD=
```

## Correr en local

```bash
docker compose up --build -d
```

## Deploy en producción

```bash
git pull && docker compose up --build -d
```

## Panel admin

`/admin` con las credenciales de `.env`

## Dominio

`nails.prittor.com`
