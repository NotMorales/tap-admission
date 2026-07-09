# Arquitectura de Seguridad

## Objetivo

Definir los mecanismos de autenticación, autorización y protección de la información implementados por el sistema, garantizando la confidencialidad, integridad y disponibilidad de los datos.

---

# Principios de Seguridad

El sistema se desarrollará bajo los siguientes principios:

- Autenticación mediante JWT.
- Autorización basada en perfiles y secciones.
- Protección de contraseñas mediante hashing.
- Validación de entradas.
- Eliminación lógica de registros.
- Registro de auditoría.
- Protección contra accesos no autorizados.

---

# Autenticación

La autenticación será implementada mediante JSON Web Token (JWT).

Flujo de autenticación:

```text
Usuario

↓

Login

↓

Validación de credenciales

↓

Generación del JWT

↓

Respuesta al Frontend

↓

Angular almacena el Token

↓

Cada petición incluye:

Authorization: Bearer {token}
```

---

# Autorización

El acceso al sistema estará basado en perfiles.

Cada usuario podrá tener uno o varios perfiles.

Cada perfil contendrá una o varias secciones.

Cada sección definirá las acciones permitidas.

```text
Usuario

↓

Perfiles

↓

Secciones

↓

Acciones
```

Las validaciones se realizarán tanto en Backend como en Frontend.

---

# Protección de Contraseñas

Las contraseñas nunca serán almacenadas en texto plano.

Se utilizará el mecanismo de hashing proporcionado por Laravel.

No será posible recuperar una contraseña existente.

Únicamente podrá restablecerse.

---

# Recuperación de Contraseña

Proceso:

1. El usuario captura su correo electrónico.

2. El sistema valida su existencia.

3. Se genera un token temporal.

4. Se envía un correo electrónico.

5. El usuario define una nueva contraseña.

---

# Middleware

El sistema implementará middleware para:

- Autenticación
- Autorización
- Verificación del JWT
- Registro de auditoría (cuando aplique)

---

# Policies

Las operaciones críticas serán protegidas mediante Policies.

Ejemplos:

- Crear usuarios
- Eliminar productos
- Modificar perfiles

---

# Validación de Datos

Todas las solicitudes serán validadas mediante Form Requests.

No se realizarán validaciones directamente en los Controllers.

---

# Protección de Recursos

Los siguientes recursos requerirán autenticación:

- Usuarios
- Productos
- Perfiles
- Secciones
- Bitácora

Únicamente el endpoint de Login y Recuperación de Contraseña estarán disponibles sin autenticación.

---

# Soft Delete

La eliminación física de información no estará permitida.

Todos los registros serán eliminados mediante Soft Delete.

---

# Auditoría

Las siguientes acciones generarán registros en la bitácora:

- Login
- Logout
- Create
- Update
- Delete
- Export
- Recuperación de contraseña

---

# Manejo de Errores

La API no expondrá información sensible.

Los errores internos serán registrados únicamente en el servidor.

Las respuestas hacia el cliente utilizarán mensajes controlados.

---

# Variables Sensibles

Las siguientes configuraciones serán almacenadas mediante variables de entorno:

- APP_KEY
- APP_ENV
- JWT_SECRET
- MONGODB_URI
- MAIL_HOST
- MAIL_USERNAME
- MAIL_PASSWORD

---

# CORS

La API únicamente permitirá solicitudes provenientes del dominio autorizado del Frontend.

Durante el desarrollo se permitirá el acceso desde localhost.

---

# Rate Limiting

Se implementará limitación de solicitudes en los procesos de autenticación para reducir el riesgo de ataques de fuerza bruta.

---

# Consideraciones de Seguridad

- No se expondrán contraseñas en las respuestas de la API.
- No se devolverán identificadores internos innecesarios.
- Todas las respuestas serán serializadas mediante API Resources.
- Las operaciones críticas quedarán registradas en la bitácora.
- Los permisos serán verificados en cada solicitud antes de ejecutar la lógica de negocio.