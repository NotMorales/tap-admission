# TAP Admin System - Backend

API REST desarrollada con Laravel 11, MongoDB y JWT para la gestión de usuarios, perfiles, secciones, productos, permisos, autenticación y bitácora.

## Stack

- PHP 8.3
- Laravel 11
- MongoDB
- JWT Auth
- Composer
- Postman
- CSV Export

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

## Configuración MongoDB

En `.env`:

```env
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=tap_admission_dev
DB_USERNAME=
DB_PASSWORD=
DB_AUTHENTICATION_DATABASE=admin
```

## Migraciones y Seeders

```bash
php artisan migrate
php artisan db:seed
```

Usuario inicial:

```text
Email: admin@tap.test
Password: Password123
```

## Ejecutar servidor

```bash
php artisan serve
```

URL base:

```text
http://127.0.0.1:8000/api
```

## Autenticación

El sistema utiliza JWT.

Login:

```http
POST /api/auth/login
```

Body:

```json
{
  "email": "admin@tap.test",
  "password": "Password123"
}
```

El token debe enviarse en las rutas protegidas:

```http
Authorization: Bearer {token}
```

## Módulos disponibles

- Auth
- Users
- Profiles
- Sections
- Products
- Audit Logs

## Endpoints principales

### Auth

```http
POST /auth/login
GET /auth/me
POST /auth/logout
```

### Sections

```http
GET /sections
POST /sections
GET /sections/{id}
PUT /sections/{id}
DELETE /sections/{id}
```

### Profiles

```http
GET /profiles
POST /profiles
GET /profiles/{id}
PUT /profiles/{id}
DELETE /profiles/{id}
```

### Users

```http
GET /users
POST /users
GET /users/{id}
PUT /users/{id}
DELETE /users/{id}
```

### Products

```http
GET /products
POST /products
GET /products/{id}
PUT /products/{id}
DELETE /products/{id}
GET /products/export/csv
```

### Audit Logs

```http
GET /audit-logs
GET /audit-logs/{id}
```

## Respuesta estándar

Respuesta exitosa:

```json
{
  "success": true,
  "message": "Operation completed successfully.",
  "data": {},
  "errors": null,
  "meta": {
    "timestamp": "2026-07-09T00:00:00Z",
    "request_id": "uuid",
    "api_version": "v1"
  }
}
```

Respuesta con error:

```json
{
  "success": false,
  "code": "RESOURCE_NOT_FOUND",
  "message": "Resource not found.",
  "data": null,
  "errors": null,
  "meta": {
    "timestamp": "2026-07-09T00:00:00Z",
    "request_id": "uuid",
    "api_version": "v1"
  }
}
```

## Permisos

El control de acceso se basa en:

```text
Usuario -> Perfiles -> Secciones -> Acciones
```

Acciones disponibles:

```text
VIEW
CREATE
UPDATE
DELETE
EXPORT
```

## Pruebas

```bash
php artisan test
php artisan route:list
```

## Exportaciones

Actualmente el sistema exporta productos en formato CSV:

```http
GET /api/products/export/csv
```

El CSV incluye BOM UTF-8 para compatibilidad con Excel en Windows.

## Pruebas automatizadas

El backend cuenta con pruebas Feature para:

- Auth
- Users
- Profiles
- Sections
- Products
- Audit Logs
- Authorization

Ejecutar:

```bash
php artisan test

## Bitácora

El sistema registra operaciones principales:

- CREATE
- UPDATE
- DELETE
- LOGIN
- LOGOUT
- EXPORT

La bitácora almacena:

- módulo
- acción
- registro afectado
- usuario
- IP
- user agent
- datos anteriores
- datos nuevos

## Convenciones

- Código en inglés.
- Documentación en español.
- Respuestas API uniformes.
- Soft Delete en registros principales.
- MongoDB como persistencia principal.
- JWT para autenticación.
