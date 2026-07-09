# Pruebas del Backend

## Objetivo

Verificar el correcto funcionamiento de todos los módulos del sistema mediante pruebas automatizadas utilizando PHPUnit.

---

# Tecnologías

- PHPUnit
- Laravel Test Suite

---

# Casos de prueba implementados

## Auth

- Login exitoso
- Login con contraseña incorrecta
- Obtener usuario autenticado
- Logout

---

## Users

- Listar usuarios
- Crear usuario
- Consultar usuario
- Actualizar usuario
- Eliminar usuario

---

## Profiles

- Listar perfiles
- Crear perfil
- Consultar perfil
- Actualizar perfil
- Eliminar perfil

---

## Sections

- Listar secciones
- Crear sección
- Consultar sección
- Actualizar sección
- Eliminar sección

---

## Products

- Listar productos
- Crear producto
- Consultar producto
- Actualizar producto
- Eliminar producto

---

## Audit Logs

- Listar bitácora
- Consultar registro

---

## Authorization

- Usuario sin token
- Usuario sin permisos
- Usuario con permisos

---

## Casos adicionales

### Exportaciones

- Exportar productos PDF
- Exportar productos CSV
- Exportar usuarios PDF
- Exportar usuarios CSV
- Exportar perfiles PDF
- Exportar perfiles CSV

---

### Password Recovery

- Recuperación correcta
- Usuario inexistente

---

### Auditoría

- LOGIN
- LOGOUT
- EXPORT
- PASSWORD_RECOVERY

# Ejecución

```bash
php artisan test
```

Resultado esperado:

```
PASS
All tests passed
```

---

# Cobertura funcional

| Módulo | Cobertura |
|---------|-----------|
| Auth | 100% |
| Users | 100% |
| Profiles | 100% |
| Sections | 100% |
| Products | 100% |
| Audit Logs | 100% |
| Authorization | 100% |

---

# Objetivo de calidad

Garantizar que cualquier modificación futura no afecte el comportamiento esperado del sistema.