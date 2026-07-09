# Diseño de la API REST

## Objetivo

Definir el contrato de comunicación entre el frontend (Angular) y el backend (Laravel), estableciendo los recursos disponibles, los métodos HTTP, las convenciones de respuesta, los códigos de estado y las reglas generales de la API.

---

# Información General

| Propiedad | Valor |
|-----------|-------|
| Arquitectura | REST |
| Formato | JSON |
| Autenticación | JWT Bearer Token |
| Base URL | /api |
| Codificación | UTF-8 |

---

# Convenciones

## Content-Type

```http
Content-Type: application/json
```

## Autorización

```http
Authorization: Bearer {token}
```

---

# Respuesta Exitosa

```json
{
    "success": true,
    "message": "Operation completed successfully.",
    "data": {}
}
```

---

# Respuesta con Error

```json
{
    "success": false,
    "message": "Validation error.",
    "errors": {}
}
```

---

# Códigos HTTP

| Código | Descripción |
|---------|-------------|
| 200 | OK |
| 201 | Created |
| 204 | No Content |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 409 | Conflict |
| 422 | Validation Error |
| 500 | Internal Server Error |

---

# Recursos

## Authentication

| Método | Endpoint | Descripción | Auth |
|---------|----------|-------------|------|
| POST | /auth/login | Iniciar sesión | No |
| POST | /auth/logout | Cerrar sesión | Sí |
| POST | /auth/forgot-password | Recuperar contraseña | No |
| GET | /auth/me | Información del usuario autenticado | Sí |

---

## Users

| Método | Endpoint | Descripción |
|---------|----------|-------------|
| GET | /users | Listar usuarios |
| POST | /users | Crear usuario |
| GET | /users/{id} | Consultar usuario |
| PUT | /users/{id} | Actualizar usuario |
| DELETE | /users/{id} | Eliminar usuario (Soft Delete) |
| GET | /users/export/pdf | Exportar PDF |
| GET | /users/export/excel | Exportar Excel |

---

## Profiles

| Método | Endpoint | Descripción |
|---------|----------|-------------|
| GET | /profiles | Listar perfiles |
| POST | /profiles | Crear perfil |
| GET | /profiles/{id} | Consultar perfil |
| PUT | /profiles/{id} | Actualizar perfil |
| DELETE | /profiles/{id} | Eliminar perfil |
| GET | /profiles/export/pdf | Exportar PDF |
| GET | /profiles/export/excel | Exportar Excel |

---

## Sections

| Método | Endpoint | Descripción |
|---------|----------|-------------|
| GET | /sections | Listar secciones |
| POST | /sections | Crear sección |
| GET | /sections/{id} | Consultar sección |
| PUT | /sections/{id} | Actualizar sección |
| DELETE | /sections/{id} | Eliminar sección |

---

## Products

| Método | Endpoint | Descripción |
|---------|----------|-------------|
| GET | /products | Listar productos |
| POST | /products | Crear producto |
| GET | /products/{id} | Consultar producto |
| PUT | /products/{id} | Actualizar producto |
| DELETE | /products/{id} | Eliminar producto |
| GET | /products/export/pdf | Exportar PDF |
| GET | /products/export/excel | Exportar Excel |

---

## Audit Logs

| Método | Endpoint | Descripción |
|---------|----------|-------------|
| GET | /audit-logs | Consultar bitácora |
| GET | /audit-logs/{id} | Consultar evento |

---

# Paginación

Las consultas de listado deberán soportar paginación.

Ejemplo:

```http
GET /users?page=1&per_page=10
```

Respuesta:

```json
{
    "success": true,
    "message": "Users retrieved successfully.",
    "data": [],
    "pagination": {
        "page": 1,
        "per_page": 10,
        "total": 150,
        "last_page": 15
    }
}
```

---

# Filtros

Los recursos podrán soportar filtros mediante Query Parameters.

Ejemplo:

```http
GET /products?name=Aceite&status=ACTIVE
```

---

# Ordenamiento

```http
GET /products?sort=name&direction=asc
```

---

# Búsqueda

```http
GET /users?search=luis
```

---

# Auditoría

Las siguientes operaciones deberán generar un registro en la colección audit_logs:

- Login
- Logout
- Create
- Update
- Delete
- Export
- Password Reset

---

# Versionamiento

La API será preparada para soportar versionamiento mediante prefijos.

Ejemplo:

```text
/api/v1/users
```

Durante la primera versión del proyecto se utilizará:

```text
/api
```

dejando preparada la migración futura a `/api/v1`.