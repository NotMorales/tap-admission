# Convenciones del Proyecto

## Objetivo

Establecer las convenciones de desarrollo que deberán seguirse durante todo el ciclo de vida del proyecto para mantener consistencia, legibilidad y facilidad de mantenimiento.

---

# Idioma

## Código

Todo el código fuente será desarrollado en idioma inglés.

Ejemplos:

- Classes
- Methods
- Variables
- Routes
- Collections
- DTO
- Services

## Documentación

Toda la documentación funcional y técnica será redactada en español.

---

# Convenciones de Nombres

## Clases

Se utilizará PascalCase.

Ejemplo:

```php
UserService
ProductController
AuditLogResource
```

---

## Métodos

Se utilizará camelCase.

```php
createUser()

updateProduct()

exportToExcel()
```

---

## Variables

Se utilizará camelCase.

```php
$user

$productStatus

$createdBy
```

---

## Constantes

Se utilizará UPPER_SNAKE_CASE.

```php
MAX_PRICE

DEFAULT_PAGE_SIZE
```

---

## Archivos

Las clases tendrán el mismo nombre del archivo.

Ejemplo

```text
User.php

UserService.php

ProductRequest.php
```

---

# API

Las rutas utilizarán nombres en plural.

Correcto

```text
/api/users

/api/products

/api/profiles
```

Incorrecto

```text
/api/user

/api/product
```

---

# Formato de Respuesta

Todas las respuestas de la API utilizarán una estructura uniforme.

Respuesta exitosa

```json
{
    "success": true,
    "message": "Operation completed successfully.",
    "data": {}
}
```

Respuesta con error

```json
{
    "success": false,
    "message": "Validation error.",
    "errors": {}
}
```

---

# Manejo de Fechas

## Base de datos

ISO 8601

Ejemplo

```
2026-07-08T23:15:00Z
```

## Interfaz

DD/MM/YYYY HH:mm

Ejemplo

```
08/07/2026 17:15
```

---

# Eliminación de Registros

El sistema implementará Soft Delete.

No se permitirá la eliminación física de registros.

---

# Auditoría

Todas las entidades principales deberán registrar:

- created_at
- created_by
- updated_at
- updated_by
- deleted_at
- deleted_by

---

# Estados

Los estados funcionales serán implementados mediante Enums.

No se utilizarán cadenas de texto directamente en el código.

Correcto

```php
UserStatus::ACTIVE
```

Incorrecto

```php
"ACTIVE"
```

---

# Commits

Se utilizará Conventional Commits.

Ejemplos

```
feat: add user authentication

fix: validate product price

docs: update api documentation

refactor: improve audit service
```

---

# Calidad de Código

Se seguirán los siguientes principios:

- SOLID
- DRY
- KISS
- Clean Code
- PSR-12

---

# Herramientas

Backend

- Laravel Pint

Frontend

- ESLint
- Prettier

---

# Ramas

main

Contendrá únicamente versiones estables.

feature/*

Nuevas funcionalidades.

fix/*

Corrección de errores.

hotfix/*

Correcciones urgentes.

---

# Principio General

Antes de implementar una funcionalidad deberán existir:

- Requerimiento definido.
- Modelo de datos.
- Endpoint documentado.
- Validaciones identificadas.

Posteriormente se desarrollará el código correspondiente.