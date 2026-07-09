# Arquitectura del Sistema

## Objetivo

Definir la arquitectura técnica del sistema, las responsabilidades de cada componente y las decisiones de diseño que permitirán construir una aplicación escalable, mantenible y desacoplada.

---

# Estilo Arquitectónico

El sistema seguirá una arquitectura cliente-servidor basada en una API REST desacoplada.

La aplicación estará dividida en dos proyectos independientes:

- Frontend desarrollado en Angular 19.
- Backend desarrollado en Laravel 11.

La comunicación entre ambos componentes se realizará mediante peticiones HTTP utilizando JSON como formato de intercambio de información.

---

# Arquitectura General

```text
                   Usuario
                      │
                      ▼
             Angular 19 (SPA)
                      │
          HTTP / HTTPS + JWT
                      │
                      ▼
          Laravel 11 REST API
                      │
        ┌─────────────┴─────────────┐
        │                           │
        ▼                           ▼
 Controllers                  Middleware
        │
        ▼
     Services
        │
        ▼
 Repositories
        │
        ▼
    MongoDB
```

---

# Separación de Responsabilidades

La solución se divide en capas claramente definidas.

## Frontend

Responsabilidades:

- Presentación de información.
- Validación básica de formularios.
- Consumo de la API.
- Administración del estado de autenticación.
- Gestión de navegación.
- Control visual de permisos.

El frontend no contendrá reglas de negocio.

---

## Backend

Responsabilidades:

- Validaciones.
- Reglas de negocio.
- Seguridad.
- Persistencia.
- Generación de reportes.
- Bitácora.
- Autorización.

Toda la lógica de negocio residirá exclusivamente en el backend.

---

# Capas del Backend

## Controllers

Responsables de:

- recibir solicitudes HTTP
- validar Request
- invocar Services
- devolver Resources

Los Controllers no contendrán lógica de negocio.

---

## Services

Implementan toda la lógica del sistema.

Ejemplos:

- crear usuario
- editar producto
- validar permisos
- generar código automático
- registrar bitácora

---

## Repositories

Abstraen completamente el acceso a MongoDB.

Esto permite cambiar la tecnología de persistencia sin modificar la lógica del negocio.

---

## Models

Representan las colecciones de MongoDB.

No contendrán reglas de negocio.

---

## Resources

Transforman las respuestas de la API.

Permiten mantener un contrato consistente entre Backend y Frontend.

---

# Flujo de una petición

```text
Angular

↓

HTTP Request

↓

Laravel Route

↓

Middleware

↓

Controller

↓

Service

↓

Repository

↓

MongoDB

↓

Repository

↓

Service

↓

Resource

↓

JSON

↓

Angular
```

---

# Arquitectura Frontend

El frontend seguirá una arquitectura modular basada en funcionalidades.

```text
src/app

core/

shared/

layout/

features/

auth/
```

## Core

Contendrá componentes reutilizables del sistema.

Ejemplo:

- interceptors
- guards
- auth
- services globales

---

## Shared

Componentes compartidos.

Ejemplo:

- botones
- tablas
- diálogos
- pipes
- utilidades

---

## Features

Cada módulo del sistema será independiente.

Ejemplo:

features/

users/

products/

profiles/

audit/

---

# Comunicación

Toda comunicación entre Angular y Laravel se realizará mediante:

- HTTPS
- JSON
- JWT

No existirá acceso directo a la base de datos.

---

# Manejo de Errores

Todas las respuestas utilizarán una estructura uniforme.

Ejemplo:

```json
{
    "success": false,
    "message": "Validation error.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```

Las respuestas exitosas mantendrán el mismo formato.

---

# Registro de Auditoría

Las operaciones críticas registrarán automáticamente:

- usuario
- acción
- módulo
- información anterior
- información nueva
- fecha
- dirección IP
- navegador

La bitácora será implementada como un componente transversal de la aplicación.

---

# Principios Aplicados

Durante el desarrollo se aplicarán los siguientes principios:

- SOLID
- DRY
- KISS
- Separation of Concerns
- Clean Architecture (adaptada)
- Clean Code

---

# Patrones de Diseño

Se utilizarán los siguientes patrones:

- Repository Pattern
- Service Layer
- Dependency Injection
- Factory (cuando aplique)
- Strategy (si se requiere para exportaciones) (si me da tiempo)
- Resource Pattern de Laravel

---

# Beneficios de la Arquitectura

La arquitectura propuesta ofrece las siguientes ventajas:

- Bajo acoplamiento.
- Alta cohesión.
- Facilidad para pruebas.
- Escalabilidad.
- Reutilización de componentes.
- Independencia entre frontend y backend.
- Mantenimiento simplificado.
- Facilidad para incorporar nuevos módulos.