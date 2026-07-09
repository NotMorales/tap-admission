# TAP Admission System

Sistema administrativo desarrollado como prueba técnica para la gestión de usuarios, perfiles, secciones, productos y bitácora de auditoría, implementando una arquitectura escalable basada en Laravel y Angular.

---

## Descripción

TAP Admission System es una aplicación Full Stack que implementa un sistema administrativo con autenticación JWT, autorización basada en permisos, auditoría de acciones, exportación de información y una arquitectura desacoplada mediante Repository Pattern y Service Layer.

El objetivo del proyecto es demostrar buenas prácticas de desarrollo, separación de responsabilidades y una arquitectura mantenible para aplicaciones empresariales.

---

# Arquitectura

```
                Angular 19
                     │
                     │ REST API
                     ▼
              Laravel 12 API
                     │
        ┌────────────┴────────────┐
        │                         │
   Controllers              Policies
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

# Tecnologías utilizadas

## Backend

- PHP 8.3
- Laravel 12
- MongoDB
- JWT Authentication
- PHPUnit
- Repository Pattern
- Service Layer
- Policy Authorization
- Observer Pattern

## Frontend

- Angular 19
- Angular Material
- RxJS
- Standalone Components
- Reactive Forms
- SCSS

---

# Funcionalidades implementadas

## Autenticación

- Inicio de sesión mediante JWT
- Obtención del usuario autenticado
- Cierre de sesión
- Protección de rutas
- Interceptor JWT

---

## Administración de Usuarios

- Listado
- Consulta individual
- Alta
- Edición
- Eliminación lógica
- Fotografía de usuario
- Código automático

---

## Administración de Perfiles

- CRUD completo
- Permisos asociados
- Código automático

---

## Administración de Secciones

- CRUD completo
- Asociación de permisos

---

## Administración de Productos

- CRUD completo
- Código automático
- Exportación PDF
- Exportación CSV

---

## Bitácora

Registro automático de:

- Login
- Logout
- Altas
- Ediciones
- Eliminaciones

---

## Seguridad

- JWT Authentication
- Policies
- Middleware
- Validaciones
- Soft Deletes
- Auditoría

---

## Exportaciones

- PDF
- CSV

---

## Pruebas

Se implementaron pruebas automatizadas para:

- Autenticación
- Autorización
- CRUD
- Policies

---

# Estructura del proyecto

```
tap-admission/
│
├── backend/
│   ├── app/
│   ├── routes/
│   ├── tests/
│   └── README.md
│
├── frontend/
│   ├── src/
│   └── README.md
│
├── postman/
│
└── README.md
```

---

# Instalación

## Clonar repositorio

```bash
git clone https://github.com/NotMorales/tap-admission.git
```

---

# Backend

Entrar al proyecto

```bash
cd backend
```

Instalar dependencias

```bash
composer install
```

Copiar variables

```bash
cp .env.example .env
```

Generar llave

```bash
php artisan key:generate
```

Generar JWT Secret

```bash
php artisan jwt:secret
```

Ejecutar Seeders

```bash
php artisan db:seed
```

Levantar servidor

```bash
php artisan serve
```

---

# Frontend

Entrar al proyecto

```bash
cd frontend
```

Instalar dependencias

```bash
npm install
```

Levantar aplicación

```bash
ng serve
```

---

# Credenciales de prueba

Administrador

```
Correo:
admin@tap.test

Contraseña:
Password123
```

---

# Documentación

## Backend

Toda la documentación técnica del backend se encuentra en:

```
backend/README.md
```

Incluye:

- Arquitectura
- Endpoints
- Estructura
- Repository Pattern
- Services
- Policies
- Testing

---

## Colección Postman

Se incluye una colección completa para probar todos los endpoints.

```
postman/
```

---

# Ejecutar pruebas

```bash
php artisan test
```

También es posible ejecutar únicamente un conjunto específico:

```bash
php artisan test --filter=AuthTest
```

---

# Características técnicas

- Arquitectura limpia
- Repository Pattern
- Service Layer
- Dependency Injection
- JWT
- Policies
- Observer Pattern
- Soft Deletes
- MongoDB
- Exportación PDF
- Exportación CSV
- Auditoría
- Código automático
- Standalone Components
- Angular Material

---

# Estado del proyecto

| Módulo | Estado |
|---------|:------:|
| Backend API | ✅ |
| JWT | ✅ |
| Policies | ✅ |
| CRUD Usuarios | ✅ |
| CRUD Productos | ✅ |
| CRUD Perfiles | ✅ |
| CRUD Secciones | ✅ |
| Bitácora | ✅ |
| Exportación PDF | ✅ |
| Exportación CSV | ✅ |
| Pruebas Backend | ✅ |
| Colección Postman | ✅ |
| Frontend Angular | 🚧 En desarrollo |

---

## Autor

**Luis Antonio Morales Velázquez**

**Ingeniero de Software · Maestro en Ingeniería de Software y Sistemas Informáticos **

Profesionista especializado en el desarrollo de software empresarial y arquitecturas web modernas. Cuenta con experiencia en el diseño e implementación de aplicaciones Full Stack utilizando Laravel, Angular, MongoDB y AWS, así como en el desarrollo de APIs REST y la aplicación de principios de arquitectura limpia. Actualmente combina su actividad profesional con la docencia universitaria e investigación.

GitHub:

https://github.com/NotMorales

---

# Licencia

Este proyecto fue desarrollado exclusivamente con fines académicos y como prueba técnica.