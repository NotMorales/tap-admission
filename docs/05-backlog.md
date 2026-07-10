# Backlog del Proyecto

## Estado
- ⬜ Pendiente
- 🟡 En progreso
- ✅ Completada
- 🔁 Ajustada

---

# Épica 1 - Configuración del Proyecto

| Estado | Tarea |
|--------|-------|
| ✅ | Configuración del entorno |
| ✅ | Crear proyecto Laravel 11 |
| ✅ | Configurar MongoDB |
| ✅ | Configurar JWT |
| ✅ | Configurar Git |
| ⬜ | Configurar Docker |
| ✅ | Crear proyecto Angular |

---

# Épica 2 - Backend Core

| Estado | Tarea |
|--------|-------|
| ✅ | Arquitectura Controller-Service-Repository |
| ✅ | BaseModel |
| ✅ | BaseService |
| ✅ | BaseRepository |
| ✅ | Enums |
| ✅ | Form Requests |
| ✅ | API Resources |
| ✅ | Respuestas estándar |
| ✅ | Manejo de errores con code |
| ✅ | Soft Delete |
| ✅ | Filtros y paginación |
| ✅ | Generación automática de códigos |
| ✅ | Exportaciones PDF y CSV |
| ✅ | Refactorización de Controllers |

---

# Épica 3 - Autenticación y Autorización

| Estado | Tarea |
|--------|-------|
| ✅ | Login |
| ✅ | Logout |
| ✅ | Auth Me |
| ✅ | JWT |
| ✅ | Middleware auth |
| ✅ | Middleware permission |
| ✅ | Contexto usuario-perfiles-secciones |
| ✅ | Permisos por perfil |
| ⬜ | Refresh token |
| ✅ | Recuperación de contraseña |

---

# Épica 4 - Módulos Backend

| Estado | Tarea |
|--------|-------|
| ✅ | Sections CRUD |
| ✅ | Profiles CRUD |
| ✅ | Users CRUD |
| ✅ | Products CRUD |
| ✅ | Audit Logs |
| ✅ | Seeders base |
| ✅ | Índices MongoDB |
| ✅ | Subida de fotografías |
| ✅ | Exportaciones por módulo |
| ✅ | Policies |

---

# Épica 5 - Exportaciones

| Estado | Tarea |
|--------|-------|
| ✅ | Exportar productos CSV |
| ✅ | Exportar productos PDF |
| ✅ | Exportar usuarios CSV |
| ✅ | Exportar usuarios PDF |
| ✅ | Exportar perfiles CSV |
| ✅ | Exportar perfiles PDF |
| 🔁 | Excel real (.xlsx) queda como mejora futura |

---

# Épica 6 - Bitácora

| Estado | Tarea |
|--------|-------|
| ✅ | Modelo AuditLog |
| ✅ | Registrar CREATE |
| ✅ | Registrar UPDATE |
| ✅ | Registrar DELETE |
| ✅ | Registrar LOGIN |
| ✅ | Registrar LOGOUT |
| 🟡 | Registrar EXPORT |
| ✅ | Consulta de bitácora |
| ✅ | Detalle de auditoría |

> **Nota:** El registro de exportaciones queda marcado como **En progreso** hasta validar que todas las exportaciones (PDF y CSV) generen correctamente su evento en la bitácora.

---

# Épica 7 - Pruebas

| Estado | Tarea |
|--------|-------|
| ✅ | AuthTest |
| ✅ | ProductTest |
| ✅ | SectionTest |
| ✅ | ProfileTest |
| ✅ | UserTest |
| ✅ | AuditLogTest |
| ✅ | AuthorizationTest |
| ✅ | ApiTestCase base |

---

# Épica 8 - Documentación

| Estado | Tarea |
|--------|-------|
| ✅ | README backend |
| ✅ | README principal |
| ✅ | Backlog |
| ⬜ | docs/06-pruebas.md |
| ✅ | docs/07-postman.md |
| ⬜ | Exportar colección Postman |
| ⬜ | Swagger/OpenAPI |

---

# Épica 9 - Frontend Angular

| Estado | Tarea |
|--------|-------|
| ✅ | Crear proyecto Angular |
| ✅ | Configurar estructura |
| ✅ | Login |
| ✅ | Layout principal |
| ✅ | Menú dinámico desde /auth/me |
| ✅ | Guards |
| ✅ | Interceptor JWT |
| ✅ | Productos (CRUD + Exportaciones + Detalle) |
| ✅ | Usuarios (CRUD + Foto + Detalle) |
| ✅ | Perfiles (CRUD + Permisos + Detalle) |
| ✅ | Secciones (CRUD + Detalle) |
| ✅ | Bitácora (Listado + Detalle) |
| 🟡 | Dashboard con métricas |
| 🟡 | Pulido visual (UX/UI) |

---

# Épica 10 - Despliegue

| Estado | Tarea |
|--------|-------|
| ⬜ | Dockerfile backend |
| ⬜ | Dockerfile frontend |
| ⬜ | Docker Compose |
| ⬜ | Variables de entorno |
| ⬜ | Pruebas finales |

---

# Resumen del Proyecto

| Área | Avance |
|------|:------:|
| Backend | ✅ 100% |
| API REST | ✅ 100% |
| Testing | ✅ 100% |
| Frontend | 🟡 95% |
| Documentación | 🟡 95% |
| Despliegue | ⬜ 0% |

## Pendientes principales

- Dashboard con métricas reales.
- Refinamiento visual del frontend.
- Documentación de pruebas (`docs/06-pruebas.md`).
- Exportar la colección de Postman.
- Docker y Docker Compose.
- Swagger / OpenAPI (opcional).