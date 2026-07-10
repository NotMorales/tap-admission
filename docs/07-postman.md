# Documentación de Postman

## 1. Objetivo

Esta colección permite probar la API REST del sistema TAP Admission, incluyendo:

- Autenticación JWT.
- Recuperación de contraseña.
- Usuarios.
- Perfiles.
- Secciones.
- Productos.
- Fotografías de usuario.
- Exportaciones PDF y CSV.
- Bitácora de auditoría.
- Validaciones.
- Autorización por permisos.

---

# 2. Requisitos previos

Antes de ejecutar las peticiones:

1. MongoDB debe estar iniciado.
2. El backend debe estar ejecutándose.
3. La base de datos debe contener los seeders iniciales.
4. Postman debe tener configuradas las variables de colección.

Ejecutar el backend:

```bash
cd backend
php artisan serve
```

URL predeterminada:

```text
http://127.0.0.1:8000
```

Ejecutar seeders:

```bash
php artisan db:seed
```

Credenciales iniciales:

```text
Correo: admin@tap.test
Contraseña: Password123
```

---

# 3. Crear la colección

En Postman:

1. Seleccionar **Collections**.
2. Presionar **New Collection**.
3. Asignar el nombre:

```text
TAP Admin System API
```

4. Crear las siguientes carpetas:

```text
Auth
Sections
Profiles
Users
Products
Audit Logs
Negative Tests
```

---

# 4. Variables de colección

Dentro de la colección:

1. Abrir **Variables**.
2. Crear las siguientes variables:

| Variable | Initial value | Current value |
|---|---|---|
| `base_url` | `http://127.0.0.1:8000/api` | `http://127.0.0.1:8000/api` |
| `token` | vacío | vacío |
| `section_id` | vacío | vacío |
| `profile_id` | vacío | vacío |
| `user_id` | vacío | vacío |
| `product_id` | vacío | vacío |
| `audit_id` | vacío | vacío |
| `temporary_password` | vacío | vacío |

La URL base se utilizará de esta manera:

```text
{{base_url}}/auth/login
```

---

# 5. Autorización de la colección

En la colección:

1. Abrir la pestaña **Authorization**.
2. En **Auth Type**, seleccionar:

```text
Bearer Token
```

3. En Token colocar:

```text
{{token}}
```

Las peticiones protegidas podrán usar:

```text
Inherit auth from parent
```

Las peticiones públicas, como Login y Recover Password, deben usar:

```text
No Auth
```

---

# 6. Headers generales

Para peticiones JSON:

```http
Accept: application/json
Content-Type: application/json
```

Para subir fotografía:

```http
Accept: application/json
Authorization: Bearer {{token}}
```

No se debe configurar manualmente:

```http
Content-Type: application/json
```

en una petición `multipart/form-data`, porque Postman debe generar automáticamente el boundary.

---

# 7. Auth

## 7.1 Login

### Request

```http
POST {{base_url}}/auth/login
```

### Authorization

```text
No Auth
```

### Body

Seleccionar:

```text
Body → raw → JSON
```

```json
{
  "email": "admin@tap.test",
  "password": "Password123"
}
```

### Respuesta esperada

```http
200 OK
```

```json
{
  "success": true,
  "message": "Login successful.",
  "data": {
    "access_token": "JWT",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {},
    "profiles": [],
    "sections": []
  },
  "errors": null,
  "meta": {}
}
```

### Tests

En la pestaña **Scripts → Post-response**:

```javascript
pm.test('Login exitoso', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

pm.test('La respuesta contiene el token', function () {
    pm.expect(response.data.access_token).to.exist;
});

pm.collectionVariables.set(
    'token',
    response.data.access_token
);
```

---

## 7.2 Usuario autenticado

```http
GET {{base_url}}/auth/me
```

### Authorization

```text
Inherit auth from parent
```

### Respuesta esperada

```http
200 OK
```

Debe devolver:

- Usuario.
- Perfiles.
- Secciones.
- Permisos disponibles.

### Tests

```javascript
pm.test('Usuario autenticado obtenido', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

pm.test('Contiene usuario, perfiles y secciones', function () {
    pm.expect(response.data.user).to.exist;
    pm.expect(response.data.profiles).to.be.an('array');
    pm.expect(response.data.sections).to.be.an('array');
});
```

---

## 7.3 Recuperar contraseña

```http
POST {{base_url}}/auth/recover-password
```

### Authorization

```text
No Auth
```

### Body

```json
{
  "email": "admin@tap.test"
}
```

### Respuesta esperada

```http
200 OK
```

Durante la etapa de demostración, la API devuelve una contraseña temporal.

### Tests

```javascript
pm.test('Contraseña temporal generada', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.temporary_password) {
    pm.collectionVariables.set(
        'temporary_password',
        response.data.temporary_password
    );
}
```

---

## 7.4 Logout

```http
POST {{base_url}}/auth/logout
```

### Authorization

```text
Inherit auth from parent
```

### Body

```json
{}
```

### Respuesta esperada

```http
200 OK
```

### Test

```javascript
pm.test('Logout exitoso', function () {
    pm.response.to.have.status(200);
});
```

Se recomienda ejecutar Logout al final de todas las pruebas.

---

# 8. Sections

## 8.1 Listar secciones

```http
GET {{base_url}}/sections
```

### Parámetros opcionales

```text
search=Usuarios
status=ACTIVE
sort=order
direction=asc
page=1
per_page=10
```

Ejemplo:

```http
GET {{base_url}}/sections?search=Usuarios&status=ACTIVE&sort=order&direction=asc
```

### Tests

```javascript
pm.test('Listado de secciones obtenido', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.length > 0) {
    pm.collectionVariables.set(
        'section_id',
        response.data[0].id
    );
}
```

---

## 8.2 Crear sección

```http
POST {{base_url}}/sections
```

### Body

```json
{
  "code": "SEC-000010",
  "name": "Compras",
  "route": "/purchases",
  "icon": "shopping_cart",
  "permissions": [
    "VIEW",
    "CREATE",
    "UPDATE",
    "DELETE",
    "EXPORT"
  ],
  "order": 10,
  "status": "ACTIVE"
}
```

### Respuesta esperada

```http
201 Created
```

### Tests

```javascript
pm.test('Sección creada', function () {
    pm.response.to.have.status(201);
});

const response = pm.response.json();

pm.collectionVariables.set(
    'section_id',
    response.data.id
);
```

---

## 8.3 Consultar sección

```http
GET {{base_url}}/sections/{{section_id}}
```

---

## 8.4 Actualizar sección

```http
PUT {{base_url}}/sections/{{section_id}}
```

### Body

```json
{
  "name": "Compras y adquisiciones",
  "route": "/purchases",
  "icon": "shopping_bag",
  "permissions": [
    "VIEW",
    "CREATE",
    "UPDATE",
    "DELETE",
    "EXPORT"
  ],
  "order": 10,
  "status": "ACTIVE"
}
```

---

## 8.5 Eliminar sección

```http
DELETE {{base_url}}/sections/{{section_id}}
```

La eliminación es lógica mediante Soft Delete.

---

# 9. Profiles

## 9.1 Listar perfiles

```http
GET {{base_url}}/profiles
```

### Tests

```javascript
pm.test('Listado de perfiles obtenido', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.length > 0) {
    pm.collectionVariables.set(
        'profile_id',
        response.data[0].id
    );
}
```

---

## 9.2 Crear perfil

El código se genera automáticamente.

```http
POST {{base_url}}/profiles
```

### Body

Usar un `section_id` válido:

```json
{
  "name": "Perfil de prueba",
  "permissions": [
    {
      "section_id": "{{section_id}}",
      "actions": [
        "VIEW",
        "CREATE",
        "UPDATE"
      ]
    }
  ],
  "status": "ACTIVE"
}
```

### Respuesta esperada

```http
201 Created
```

Debe generar un código similar a:

```text
PRF-000004
```

### Tests

```javascript
pm.test('Perfil creado', function () {
    pm.response.to.have.status(201);
});

const response = pm.response.json();

pm.collectionVariables.set(
    'profile_id',
    response.data.id
);

pm.test('Código generado automáticamente', function () {
    pm.expect(response.data.code).to.match(/^PRF-\d{6}$/);
});
```

---

## 9.3 Consultar perfil

```http
GET {{base_url}}/profiles/{{profile_id}}
```

Debe devolver:

- Código.
- Nombre.
- Estado.
- Permisos relacionados.
- Secciones asociadas.

---

## 9.4 Actualizar perfil

```http
PUT {{base_url}}/profiles/{{profile_id}}
```

### Body

```json
{
  "name": "Perfil de prueba actualizado",
  "permissions": [
    {
      "section_id": "{{section_id}}",
      "actions": [
        "VIEW",
        "CREATE",
        "UPDATE",
        "DELETE",
        "EXPORT"
      ]
    }
  ],
  "status": "ACTIVE"
}
```

---

## 9.5 Eliminar perfil

```http
DELETE {{base_url}}/profiles/{{profile_id}}
```

---

## 9.6 Exportar perfiles CSV

```http
GET {{base_url}}/profiles/export/csv
```

En Postman seleccionar:

```text
Send and Download
```

Nombre sugerido:

```text
profiles.csv
```

---

## 9.7 Exportar perfiles PDF

```http
GET {{base_url}}/profiles/export/pdf
```

Seleccionar:

```text
Send and Download
```

Nombre sugerido:

```text
profiles.pdf
```

---

# 10. Users

## 10.1 Listar usuarios

```http
GET {{base_url}}/users
```

### Parámetros opcionales

```text
search=admin
status=ACTIVE
sort=name
direction=asc
page=1
per_page=10
```

### Tests

```javascript
pm.test('Listado de usuarios obtenido', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.length > 0) {
    pm.collectionVariables.set(
        'user_id',
        response.data[0].id
    );
}
```

---

## 10.2 Crear usuario

El código se genera automáticamente.

```http
POST {{base_url}}/users
```

### Body

```json
{
  "name": "Usuario de prueba",
  "email": "usuario.prueba@tap.test",
  "password": "Password123",
  "phone": "+529211234567",
  "profile_ids": [
    "{{profile_id}}"
  ],
  "status": "ACTIVE"
}
```

### Respuesta esperada

```http
201 Created
```

Debe generar un código como:

```text
USR-000002
```

### Tests

```javascript
pm.test('Usuario creado', function () {
    pm.response.to.have.status(201);
});

const response = pm.response.json();

pm.collectionVariables.set(
    'user_id',
    response.data.id
);

pm.test('Código de usuario automático', function () {
    pm.expect(response.data.code).to.match(/^USR-\d{6}$/);
});
```

---

## 10.3 Consultar usuario

```http
GET {{base_url}}/users/{{user_id}}
```

Debe devolver:

- Usuario o correo.
- Nombre.
- Teléfono.
- Fotografía.
- `profile_ids`.
- Perfiles relacionados.
- Estado.

---

## 10.4 Actualizar usuario

```http
PUT {{base_url}}/users/{{user_id}}
```

### Body

```json
{
  "name": "Usuario actualizado",
  "email": "usuario.actualizado@tap.test",
  "phone": "+529219999999",
  "profile_ids": [
    "{{profile_id}}"
  ],
  "status": "ACTIVE"
}
```

La contraseña puede omitirse si no se desea cambiar.

Para cambiarla:

```json
{
  "password": "NuevaPassword123"
}
```

---

## 10.5 Subir fotografía

```http
POST {{base_url}}/users/{{user_id}}/photo
```

### Body

Seleccionar:

```text
Body → form-data
```

Agregar:

| Key | Type | Value |
|---|---|---|
| `photo` | File | Seleccionar JPG, JPEG, PNG o WEBP |

No agregar manualmente `Content-Type`.

### Restricciones

- Formatos: JPG, JPEG, PNG y WEBP.
- Tamaño máximo: 2 MB.

### Respuesta esperada

```http
200 OK
```

Debe devolver:

```json
{
  "photo": "users/photos/archivo.jpg",
  "photo_url": "http://127.0.0.1:8000/storage/users/photos/archivo.jpg"
}
```

---

## 10.6 Eliminar usuario

```http
DELETE {{base_url}}/users/{{user_id}}
```

---

## 10.7 Exportar usuarios CSV

```http
GET {{base_url}}/users/export/csv
```

Usar:

```text
Send and Download
```

Nombre sugerido:

```text
users.csv
```

---

## 10.8 Exportar usuarios PDF

```http
GET {{base_url}}/users/export/pdf
```

Nombre sugerido:

```text
users.pdf
```

---

# 11. Products

## 11.1 Listar productos

```http
GET {{base_url}}/products
```

### Parámetros opcionales

```text
search=Filtro
status=ACTIVE
sort=name
direction=asc
page=1
per_page=10
```

Ejemplo:

```http
GET {{base_url}}/products?search=Filtro&status=ACTIVE&sort=name&direction=asc&page=1&per_page=10
```

### Tests

```javascript
pm.test('Listado de productos obtenido', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.length > 0) {
    pm.collectionVariables.set(
        'product_id',
        response.data[0].id
    );
}
```

---

## 11.2 Crear producto

El código del producto se genera automáticamente.

```http
POST {{base_url}}/products
```

### Body

```json
{
  "name": "Producto de prueba",
  "brand": "TAP",
  "price": 250,
  "status": "ACTIVE"
}
```

### Respuesta esperada

```http
201 Created
```

Código generado:

```text
PROD-000005
```

### Tests

```javascript
pm.test('Producto creado', function () {
    pm.response.to.have.status(201);
});

const response = pm.response.json();

pm.collectionVariables.set(
    'product_id',
    response.data.id
);

pm.test('Código de producto automático', function () {
    pm.expect(response.data.code).to.match(/^PROD-\d{6}$/);
});
```

---

## 11.3 Consultar producto

```http
GET {{base_url}}/products/{{product_id}}
```

---

## 11.4 Actualizar producto

```http
PUT {{base_url}}/products/{{product_id}}
```

### Body

```json
{
  "name": "Producto actualizado",
  "brand": "TAP",
  "price": 325,
  "status": "ACTIVE"
}
```

---

## 11.5 Eliminar producto

```http
DELETE {{base_url}}/products/{{product_id}}
```

---

## 11.6 Exportar productos CSV

```http
GET {{base_url}}/products/export/csv
```

Usar:

```text
Send and Download
```

Nombre sugerido:

```text
products.csv
```

El archivo incluye BOM UTF-8 para permitir la correcta visualización de acentos en Microsoft Excel.

---

## 11.7 Exportar productos PDF

```http
GET {{base_url}}/products/export/pdf
```

Usar:

```text
Send and Download
```

Nombre sugerido:

```text
products.pdf
```

---

# 12. Audit Logs

## 12.1 Listar bitácora

```http
GET {{base_url}}/audit-logs
```

### Parámetros opcionales

```text
search=AUTH
sort=created_at
direction=desc
page=1
per_page=10
```

Ejemplo:

```http
GET {{base_url}}/audit-logs?search=AUTH&sort=created_at&direction=desc
```

### Tests

```javascript
pm.test('Bitácora obtenida', function () {
    pm.response.to.have.status(200);
});

const response = pm.response.json();

if (response.data?.length > 0) {
    pm.collectionVariables.set(
        'audit_id',
        response.data[0].id
    );
}
```

---

## 12.2 Consultar detalle de auditoría

```http
GET {{base_url}}/audit-logs/{{audit_id}}
```

Puede devolver:

- Módulo.
- Acción.
- Usuario.
- IP.
- User Agent.
- Registro afectado.
- Datos anteriores.
- Datos nuevos.
- Fecha de creación.

---

# 13. Pruebas negativas

## 13.1 Acceso sin token

Crear una petición:

```http
GET {{base_url}}/products
```

En Authorization seleccionar:

```text
No Auth
```

### Respuesta esperada

```http
401 Unauthorized
```

### Test

```javascript
pm.test('La API rechaza solicitudes sin token', function () {
    pm.response.to.have.status(401);
});
```

---

## 13.2 Credenciales incorrectas

```http
POST {{base_url}}/auth/login
```

```json
{
  "email": "admin@tap.test",
  "password": "Incorrecta"
}
```

### Respuesta esperada

```http
401 Unauthorized
```

---

## 13.3 Producto inexistente

```http
GET {{base_url}}/products/000000000000000000000000
```

### Respuesta esperada

```http
404 Not Found
```

```json
{
  "success": false,
  "code": "RESOURCE_NOT_FOUND",
  "message": "Product not found.",
  "data": null
}
```

---

## 13.4 Validación de producto

```http
POST {{base_url}}/products
```

```json
{
  "name": "",
  "brand": "",
  "price": 0,
  "status": "INVALID"
}
```

### Respuesta esperada

```http
422 Unprocessable Content
```

---

## 13.5 Usuario sin perfiles

```http
POST {{base_url}}/users
```

```json
{
  "name": "Usuario sin perfil",
  "email": "sin.perfil@tap.test",
  "password": "Password123",
  "phone": "+529211234567",
  "status": "ACTIVE"
}
```

### Respuesta esperada

```http
422 Unprocessable Content
```

Debe indicar:

```text
The profile ids field is required.
```

---

## 13.6 Permiso denegado

1. Crear un perfil que únicamente tenga `VIEW` en Productos.
2. Crear un usuario con ese perfil.
3. Iniciar sesión con dicho usuario.
4. Intentar:

```http
POST {{base_url}}/products
```

### Respuesta esperada

```http
403 Forbidden
```

```json
{
  "success": false,
  "code": "FORBIDDEN",
  "message": "You do not have permission to perform this action."
}
```

---

# 14. Orden recomendado de ejecución

Ejecutar las peticiones en el siguiente orden:

```text
1. Auth / Login
2. Auth / Me
3. Sections / Index
4. Sections / Create
5. Profiles / Index
6. Profiles / Create
7. Users / Index
8. Users / Create
9. Users / Upload Photo
10. Products / Index
11. Products / Create
12. Products / Update
13. Products / Export CSV
14. Products / Export PDF
15. Users / Export CSV
16. Users / Export PDF
17. Profiles / Export CSV
18. Profiles / Export PDF
19. Audit Logs / Index
20. Audit Logs / Show
21. Negative Tests
22. Auth / Logout
```

---

# 15. Ejecución automática de la colección

Para ejecutar toda la colección:

1. Abrir la colección.
2. Presionar **Run collection**.
3. Seleccionar las peticiones.
4. Configurar:

```text
Iterations: 1
Delay: 0 ms
Persist responses: opcional
```

5. Presionar **Run TAP Admin System API**.

No se recomienda incluir Logout antes de terminar las peticiones protegidas, porque el token quedará invalidado.

---

# 16. Exportar la colección

Para almacenar la colección en el repositorio:

1. Presionar los tres puntos de la colección.
2. Seleccionar **Export**.
3. Elegir:

```text
Collection v2.1
```

4. Guardar como:

```text
postman/TAP_Admin_System_API.postman_collection.json
```

También se puede exportar el environment:

```text
postman/TAP_Local.postman_environment.json
```

No se debe guardar un token JWT real en el repositorio.

---

# 17. Estructura sugerida en Postman

```text
TAP Admin System API
│
├── Auth
│   ├── Login
│   ├── Me
│   ├── Recover Password
│   └── Logout
│
├── Sections
│   ├── Index
│   ├── Create
│   ├── Show
│   ├── Update
│   └── Delete
│
├── Profiles
│   ├── Index
│   ├── Create
│   ├── Show
│   ├── Update
│   ├── Delete
│   ├── Export CSV
│   └── Export PDF
│
├── Users
│   ├── Index
│   ├── Create
│   ├── Show
│   ├── Update
│   ├── Upload Photo
│   ├── Delete
│   ├── Export CSV
│   └── Export PDF
│
├── Products
│   ├── Index
│   ├── Create
│   ├── Show
│   ├── Update
│   ├── Delete
│   ├── Export CSV
│   └── Export PDF
│
├── Audit Logs
│   ├── Index
│   └── Show
│
└── Negative Tests
    ├── Without Token
    ├── Invalid Login
    ├── Product Not Found
    ├── Validation Error
    └── Forbidden
```

---

# 18. Respuestas HTTP esperadas

| Código | Significado |
|---|---|
| `200` | Operación exitosa |
| `201` | Registro creado |
| `401` | Usuario no autenticado |
| `403` | Usuario sin permisos |
| `404` | Registro no encontrado |
| `409` | Conflicto o registro duplicado |
| `422` | Error de validación |
| `500` | Error interno del servidor |

---

# 19. Recomendaciones

- Ejecutar Login antes de las peticiones protegidas.
- Utilizar variables para identificadores y token.
- No copiar identificadores manualmente cuando pueden guardarse mediante scripts.
- Verificar que las exportaciones usen `Send and Download`.
- No establecer manualmente `Content-Type` al subir fotografías.
- No exportar tokens reales al repositorio.
- Ejecutar Logout únicamente al final.