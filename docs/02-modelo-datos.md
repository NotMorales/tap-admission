# Modelo de Datos

## Objetivo

Definir el modelo de persistencia del sistema utilizando MongoDB como base de datos NoSQL, estableciendo la estructura de las colecciones, relaciones, índices y lineamientos para la trazabilidad de la información.

---

# Base de Datos

**Nombre sugerido**

```text
tap_admin
```

---

# Colecciones

El sistema estará compuesto por las siguientes colecciones:

- users
- profiles
- sections
- products
- audit_logs
- counters

---

# Modelo Conceptual

```text
                    Users
                       │
               profile_ids[]
                       │
                       ▼
                  Profiles
                       │
               section_ids[]
                       │
                       ▼
                  Sections


                  Products


                 Audit Logs
```

---

# Convenciones Generales

Todas las colecciones principales compartirán una estructura uniforme de auditoría.

## Campos de Auditoría

| Campo | Descripción |
|--------|-------------|
| created_at | Fecha de creación |
| created_by | Usuario que creó el registro |
| updated_at | Última modificación |
| updated_by | Usuario que realizó la última modificación |
| deleted_at | Fecha de eliminación lógica |
| deleted_by | Usuario que realizó la eliminación lógica |

---

# Eliminación Lógica (Soft Delete)

El sistema implementará **Soft Delete** para preservar la trazabilidad de la información.

Un registro será considerado **vigente** cuando:

```text
deleted_at == null
```

Cuando un registro sea eliminado, únicamente se actualizarán los siguientes campos:

```json
{
    "deleted_at": "ISODate",
    "deleted_by": "ObjectId"
}
```

La eliminación física de documentos no estará permitida.

---

# Estados de Negocio

El campo **status** representa únicamente el estado funcional del registro y no determina su existencia.

Los valores permitidos para cada entidad estarán definidos mediante enumeraciones del dominio.

Ejemplos:

## Usuarios

- ACTIVE
- INACTIVE
- BLOCKED
- PENDING

## Productos

- ACTIVE
- INACTIVE

## Perfiles

- ACTIVE
- INACTIVE

## Secciones

- ACTIVE
- INACTIVE

Las consultas del sistema siempre deberán considerar ambos criterios:

- Estado funcional (`status`)
- Eliminación lógica (`deleted_at`)

La definición formal de estos valores se documenta en:

```text
docs/domain/Enums.md
```

# Colección Users

```json
{
    "_id": "ObjectId",

    "code": "USR-000001",

    "name": "Luis Morales",

    "email": "luis@test.com",

    "password": "HASH",

    "phone": "+52 9211234567",

    "photo": "users/photo.jpg",

    "profile_ids": [
        "ObjectId"
    ],

    "status": "ACTIVE",

    "created_at": "ISODate",
    "created_by": "ObjectId",

    "updated_at": "ISODate",
    "updated_by": "ObjectId",

    "deleted_at": null,
    "deleted_by": null
}
```

---

# Colección Profiles

```json
{
    "_id": "ObjectId",

    "code": "PER-000001",

    "name": "Administrador",

    "section_ids": [
        "ObjectId"
    ],

    "status": "ACTIVE",

    "created_at": "ISODate",
    "created_by": "ObjectId",

    "updated_at": "ISODate",
    "updated_by": "ObjectId",

    "deleted_at": null,
    "deleted_by": null
}
```

---

# Colección Sections

```json
{
    "_id": "ObjectId",

    "code": "SEC-000001",

    "name": "Productos",

    "route": "/products",

    "icon": "inventory",

    "permissions": [
        "view",
        "create",
        "update",
        "delete",
        "export"
    ],

    "order": 1,

    "status": "ACTIVE",

    "created_at": "ISODate",
    "created_by": "ObjectId",

    "updated_at": "ISODate",
    "updated_by": "ObjectId",

    "deleted_at": null,
    "deleted_by": null
}
```

---

# Colección Products

```json
{
    "_id": "ObjectId",

    "code": "PROD-000001",

    "name": "Aceite Hidráulico",

    "brand": "Mobil",

    "price": 250,

    "status": "ACTIVE",

    "created_at": "ISODate",
    "created_by": "ObjectId",

    "updated_at": "ISODate",
    "updated_by": "ObjectId",

    "deleted_at": null,
    "deleted_by": null
}
```

---

# Colección Audit Logs

La colección **audit_logs** almacenará el historial completo de las operaciones realizadas.

```json
{
    "_id": "ObjectId",

    "module": "products",

    "action": "UPDATE",

    "record_id": "ObjectId",

    "record_code": "PROD-000001",

    "old_data": {},

    "new_data": {},

    "performed_by": {

        "user_id": "ObjectId",

        "name": "Luis Morales",

        "email": "luis@test.com"
    },

    "request": {

        "ip": "127.0.0.1",

        "browser": "Chrome",

        "platform": "Windows"
    },

    "created_at": "ISODate"
}
```

---

# Colección Counters

MongoDB no proporciona identificadores consecutivos para códigos de negocio.

Se utilizará una colección denominada **counters**.

```json
{
    "_id": "users",
    "sequence": 15
}
```

Ejemplo:

```json
{
    "_id": "products",
    "sequence": 124
}
```

---

# Estrategia para la Generación de Códigos

Los códigos visibles para el usuario serán independientes del ObjectId.

Ejemplos:

```text
USR-000001
PER-000001
SEC-000001
PROD-000001
```

Beneficios:

- Mayor legibilidad.
- Mejor experiencia para el usuario.
- Independencia del identificador interno.
- Facilidad para reportes y auditorías.

---

# Relaciones

| Colección | Relación |
|------------|----------|
| Users → Profiles | N:M |
| Profiles → Sections | N:M |
| Audit Logs → Users | N:1 |
| Audit Logs → Registro Modificado | N:1 |

---

# Índices

## Users

- code (Unique)
- email (Unique)
- deleted_at

## Profiles

- code (Unique)
- deleted_at

## Sections

- code (Unique)
- route (Unique)
- deleted_at

## Products

- code (Unique)
- name
- brand
- deleted_at

## Audit Logs

- module
- record_code
- performed_by.user_id
- created_at

---


# Decisiones de Diseño

- Se utilizarán referencias mediante ObjectId entre usuarios, perfiles y secciones para evitar duplicidad de información.
- Todas las colecciones incorporarán auditoría operativa (`created_*`, `updated_*`, `deleted_*`).
- La eliminación de registros será exclusivamente lógica mediante Soft Delete.
- La existencia de un registro estará determinada por el valor de `deleted_at`.
- El campo `status` representará únicamente el estado funcional del negocio.
- La colección `audit_logs` almacenará el historial detallado de todas las operaciones relevantes.
- Los códigos visibles serán independientes del ObjectId para facilitar la trazabilidad.

---

# Escalabilidad

La arquitectura propuesta permite incorporar nuevos módulos sin modificar las convenciones establecidas.

Los nuevos módulos reutilizarán:

- Auditoría operativa.
- Soft Delete.
- Estados de negocio.
- Generación de códigos.
- Bitácora.
- Convenciones de índices.