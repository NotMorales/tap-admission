# Colección Postman

## Variables

| Variable | Valor |
|-----------|-------|
| base_url | http://127.0.0.1:8000/api |
| token | JWT |
| product_id | id |
| profile_id | id |
| section_id | id |
| user_id | id |

---

# Auth

POST /auth/login

GET /auth/me

POST /auth/logout

---

# Products

GET /products

POST /products

GET /products/{id}

PUT /products/{id}

DELETE /products/{id}

GET /products/export/csv

---

# Users

GET /users

POST /users

GET /users/{id}

PUT /users/{id}

DELETE /users/{id}

---

# Profiles

GET /profiles

POST /profiles

GET /profiles/{id}

PUT /profiles/{id}

DELETE /profiles/{id}

---

# Sections

GET /sections

POST /sections

GET /sections/{id}

PUT /sections/{id}

DELETE /sections/{id}

---

# Audit Logs

GET /audit-logs

GET /audit-logs/{id}

---

# Password Recovery

POST

/auth/recover-password

Body

```json
{
    "email":"admin@tap.test"
}
```

---

# Exportaciones

GET

/products/export/pdf

/products/export/csv

/users/export/pdf

/users/export/csv

/profiles/export/pdf

/profiles/export/csv

# Headers

Authorization

```
Bearer {{token}}
```

Accept

```
application/json
```

Content-Type

```
application/json
```

---

# Flujo recomendado

1 Login

↓

2 Me

↓

3 CRUD Sections

↓

4 CRUD Profiles

↓

5 CRUD Users

↓

6 CRUD Products

↓

7 Export CSV

↓

8 Audit Logs

↓

9 Logout