# Enumeraciones del Dominio

## Objetivo

Definir las enumeraciones utilizadas por el sistema para evitar valores literales dispersos en el código y centralizar conceptos del dominio.

---

# UserStatus

| Valor | Descripción |
|---|---|
| ACTIVE | Usuario habilitado para acceder al sistema. |
| INACTIVE | Usuario deshabilitado administrativamente. |
| BLOCKED | Usuario bloqueado por seguridad. |
| PENDING | Usuario creado pero pendiente de activación. |

---

# ProductStatus

| Valor | Descripción |
|---|---|
| ACTIVE | Producto disponible. |
| INACTIVE | Producto fuera de uso o deshabilitado. |

---

# ProfileStatus

| Valor | Descripción |
|---|---|
| ACTIVE | Perfil disponible para asignación. |
| INACTIVE | Perfil deshabilitado. |

---

# SectionStatus

| Valor | Descripción |
|---|---|
| ACTIVE | Sección disponible. |
| INACTIVE | Sección deshabilitada. |

---

# AuditAction

| Valor | Descripción |
|---|---|
| CREATE | Registro creado. |
| UPDATE | Registro actualizado. |
| DELETE | Registro eliminado lógicamente. |
| LOGIN | Inicio de sesión. |
| LOGOUT | Cierre de sesión. |
| EXPORT | Exportación de información. |
| PASSWORD_RESET | Recuperación de contraseña. |

---

# Module

| Valor | Descripción |
|---|---|
| USERS | Módulo de usuarios. |
| PRODUCTS | Módulo de productos. |
| PROFILES | Módulo de perfiles. |
| SECTIONS | Módulo de secciones. |
| AUDIT_LOGS | Módulo de bitácora. |
| AUTH | Módulo de autenticación. |

---

# PermissionAction

| Valor | Descripción |
|---|---|
| VIEW | Permite consultar información. |
| CREATE | Permite crear registros. |
| UPDATE | Permite modificar registros. |
| DELETE | Permite eliminar registros lógicamente. |
| EXPORT | Permite exportar información. |

---

# PermissionKey

Las llaves de permiso combinan módulo y acción.

| Valor |
|---|
| USERS_VIEW |
| USERS_CREATE |
| USERS_UPDATE |
| USERS_DELETE |
| USERS_EXPORT |
| PRODUCTS_VIEW |
| PRODUCTS_CREATE |
| PRODUCTS_UPDATE |
| PRODUCTS_DELETE |
| PRODUCTS_EXPORT |
| PROFILES_VIEW |
| PROFILES_CREATE |
| PROFILES_UPDATE |
| PROFILES_DELETE |
| PROFILES_EXPORT |
| SECTIONS_VIEW |
| SECTIONS_CREATE |
| SECTIONS_UPDATE |
| SECTIONS_DELETE |
| AUDIT_LOGS_VIEW |

---

# ExportType

| Valor | Descripción |
|---|---|
| PDF | Exportación en formato PDF. |
| EXCEL | Exportación en formato Excel. |

---

# ResponseStatus

| Valor | Descripción |
|---|---|
| SUCCESS | Respuesta exitosa. |
| ERROR | Respuesta con error. |

---

# Criterio de Diseño

Las enumeraciones serán implementadas tanto en el backend como en el frontend.

En Laravel se utilizarán enums nativos de PHP.

En Angular se utilizarán enums de TypeScript.

Esto permitirá mantener consistencia entre API, validaciones, permisos y presentación visual.