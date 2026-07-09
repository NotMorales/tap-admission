# Arquitectura Backend

## Patrón utilizado

Controller

↓

Service

↓

Repository

↓

MongoDB

---

## Capas

### Controllers

Responsables de recibir las peticiones HTTP.

No contienen lógica de negocio.

---

### Services

Contienen las reglas del negocio.

Realizan:

- Auditoría
- Validaciones de negocio
- Generación de códigos
- Coordinación de repositorios

---

### Repositories

Acceso a datos.

Incluyen:

- CRUD
- Paginación
- Filtros
- Exportaciones

---

### Models

Representación de documentos MongoDB.

---

### Resources

Transformación de respuestas.

---

### Form Requests

Validaciones.

---

### Filters

Búsquedas dinámicas.

---

### Exports

CSV

PDF

---

### Middleware

JWT

Permisos

---

### Exceptions

Respuestas homogéneas de errores.

---

### Tests

Feature Tests completos.

---

## Flujo

HTTP

↓

Controller

↓

Service

↓

Repository

↓

MongoDB

↓

Resource

↓

JSON