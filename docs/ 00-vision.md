# TAP Admin System

## Visión del Proyecto

### Descripción

TAP Admin System es una aplicación web desarrollada como solución para la prueba técnica del Área de Desarrollo de Grupo TAP. El sistema tiene como finalidad administrar productos, usuarios, perfiles y permisos mediante una arquitectura moderna basada en servicios, una API REST y una base de datos NoSQL.

Aunque el proyecto responde a los requerimientos de una evaluación técnica, su diseño se plantea con un enfoque empresarial, priorizando la escalabilidad, mantenibilidad, seguridad y facilidad de evolución.

---

# Objetivos

## Objetivo General

Diseñar e implementar un sistema web moderno utilizando Laravel 11, Angular 19 y MongoDB que permita administrar productos y usuarios mediante un esquema de autenticación, autorización basada en perfiles y registro de auditoría.

## Objetivos Específicos

- Implementar una API REST desacoplada.
- Desarrollar una interfaz web moderna con Angular.
- Gestionar usuarios, perfiles y productos.
- Implementar autenticación segura mediante JWT.
- Controlar el acceso a los módulos según los permisos asignados.
- Registrar una bitácora completa de cambios.
- Permitir la exportación de información en PDF y Excel.
- Documentar completamente la arquitectura y la API.

---

# Alcance

El sistema contempla los siguientes módulos:

- Autenticación
- Usuarios
- Perfiles
- Secciones
- Productos
- Bitácora
- Exportación de información
- Documentación de API

No forma parte del alcance el desarrollo de aplicaciones móviles ni la integración con sistemas externos.

---

# Tecnologías

| Componente | Tecnología |
|------------|------------|
| Backend | Laravel 11 |
| Lenguaje | PHP 8.3 |
| Frontend | Angular 19 |
| Lenguaje Frontend | TypeScript |
| Base de Datos | MongoDB |
| API | REST |
| Autenticación | JWT |
| Contenedores | Docker |
| Control de versiones | Git |
| Documentación API | Swagger / Postman |

---

# Principios de Diseño

El proyecto será desarrollado siguiendo principios de ingeniería de software orientados a la construcción de aplicaciones empresariales.

Entre los principales lineamientos se encuentran:

- Separación de responsabilidades.
- Arquitectura por capas.
- Principios SOLID.
- Clean Code.
- API First.
- Seguridad desde el diseño (Security by Design).
- Documentación continua.
- Versionamiento mediante Git.

---

# Arquitectura General

Frontend (Angular)

↓

API REST (Laravel)

↓

Capa de Servicios

↓

Capa de Repositorios

↓

MongoDB

---

# Criterios de Calidad

Durante el desarrollo se buscará cumplir con los siguientes atributos de calidad:

- Escalabilidad.
- Mantenibilidad.
- Reutilización.
- Seguridad.
- Bajo acoplamiento.
- Alta cohesión.
- Legibilidad del código.
- Facilidad para pruebas.

---

# Convenciones

Se utilizarán las siguientes convenciones durante todo el proyecto:

- PSR-12 para PHP.
- Convenciones oficiales de Angular.
- Commits semánticos.
- Inglés para nombres de clases, métodos, variables y rutas.
- Español únicamente para la documentación funcional.

---

# Resultado Esperado

Al finalizar el desarrollo se contará con un sistema completamente funcional, documentado y desplegable mediante Docker, capaz de satisfacer los requerimientos funcionales establecidos en la prueba técnica y servir como evidencia de buenas prácticas de desarrollo de software.