# Referencia de API — Gestión de Tareas

URL base: `http://localhost:8080`

La autenticación se gestiona mediante Laravel Sanctum (basada en cookies de sesión SPA). Todos los endpoints protegidos requieren una cookie de sesión válida.

---

## Autenticación

### Inicializar protección CSRF

Antes de cualquier petición que modifique datos, se debe obtener el token CSRF.

```
GET /sanctum/csrf-cookie
```

No requiere cuerpo. Establece la cookie `XSRF-TOKEN`, que debe enviarse como el header `X-XSRF-TOKEN` en las peticiones siguientes.

---

### Registro

```
POST /api/register
```

**Cuerpo**

| Campo                 | Tipo   | Requerido |
|-----------------------|--------|-----------|
| name                  | string | sí        |
| email                 | string | sí        |
| password              | string | sí        |
| password_confirmation | string | sí        |

**Respuesta** `201 Created`

---

### Inicio de sesión

```
POST /api/login
```

**Cuerpo**

| Campo    | Tipo   | Requerido |
|----------|--------|-----------|
| email    | string | sí        |
| password | string | sí        |

**Respuesta** `200 OK` — establece la cookie de sesión.

---

### Obtener usuario autenticado

```
GET /api/user
```

Requiere autenticación.

**Respuesta** `200 OK`

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
}
```

---

### Cierre de sesión

```
POST /api/logout
```

Requiere autenticación. Invalida la sesión actual.

**Respuesta** `204 No Content`

---

## Tareas

Todos los endpoints de tareas requieren autenticación.

### Listar tareas

```
GET /api/tasks
```

**Parámetros de consulta (todos opcionales)**

| Parámetro   | Tipo    | Valores                               |
|-------------|---------|---------------------------------------|
| status      | string  | `pending`, `in_progress`, `completed` |
| priority_id | integer | ID de la prioridad                    |
| due_date    | string  | `YYYY-MM-DD`                          |

**Respuesta** `200 OK` — listado paginado de tareas con prioridad y etiquetas.

---

### Obtener tarea

```
GET /api/tasks/{id}
```

**Respuesta** `200 OK`

---

### Crear tarea

```
POST /api/tasks
```

**Cuerpo**

| Campo       | Tipo    | Requerido |
|-------------|---------|-----------|
| title       | string  | sí        |
| description | string  | no        |
| status      | string  | no        |
| due_date    | string  | no        |
| priority_id | integer | no        |
| tag_ids     | array   | no        |

**Respuesta** `201 Created`

---

### Actualizar tarea

```
PUT /api/tasks/{id}
```

Acepta los mismos campos que Crear tarea.

**Respuesta** `200 OK`

---

### Actualizar estado de tarea

```
PATCH /api/tasks/{id}/status
```

**Cuerpo**

| Campo  | Tipo   | Valores                               |
|--------|--------|---------------------------------------|
| status | string | `pending`, `in_progress`, `completed` |

**Respuesta** `200 OK`

---

### Eliminar tarea

```
DELETE /api/tasks/{id}
```

**Respuesta** `204 No Content`

---

## Prioridades

```
GET /api/priorities
```

Requiere autenticación. Devuelve el listado de prioridades disponibles.

**Respuesta** `200 OK`

```json
[
    { "id": 1, "name": "low" },
    { "id": 2, "name": "medium" },
    { "id": 3, "name": "high" }
]
```

---

## Etiquetas

```
GET /api/tags
```

Requiere autenticación. Devuelve el listado de etiquetas disponibles.

**Respuesta** `200 OK`

```json
[
    { "id": 1, "name": "DEV" },
    { "id": 2, "name": "QA" },
    { "id": 3, "name": "HR" }
]
```

