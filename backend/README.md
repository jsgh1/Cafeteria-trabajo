# Repo Backend - API PHP CRUD Cafetería

API REST en PHP 8.2 con PDO PostgreSQL, organizada por capas para aplicar SOLID:

- `Models`: representación de cada entidad.
- `Repositories`: acceso a datos.
- `Services`: reglas y validaciones.
- `Controllers`: entrada HTTP y respuestas JSON.
- `public/index.php`: router central.

## Entidades

1. `categorias`
2. `productos`
3. `clientes`
4. `pedidos`
5. `pedido_items`

Cada entidad tiene 6 operaciones:

- Crear: `POST /api/{entidad}`
- Listar: `GET /api/{entidad}`
- Consultar por ID: `GET /api/{entidad}/{id}`
- Actualizar: `PUT /api/{entidad}/{id}`
- Eliminar: `DELETE /api/{entidad}/{id}`
- Filtrar: `GET /api/{entidad}/filter?search=texto`

Total: **5 x 6 = 30 endpoints**.

## Variables de entorno

```env
DB_HOST=postgres
DB_PORT=5432
DB_NAME=cafeteria_db
DB_USER=cafeteria_user
DB_PASSWORD=cafeteria_pass
```

## Levantar con Docker desde el proyecto completo

El backend se levanta automáticamente con el `docker-compose.yml` del zip completo.

```bash
docker compose up --build
```

Swagger queda en:

```text
http://localhost:8080/docs
```

## Probar manualmente en Swagger

1. Abre `http://localhost:8080/docs`.
2. En cada entidad abre los endpoints.
3. Primero prueba `GET /api/{entidad}` para ver datos iniciales.
4. Luego prueba `POST` con el JSON de ejemplo.
5. Copia el `id` devuelto.
6. Prueba `GET /api/{entidad}/{id}`.
7. Prueba `PUT /api/{entidad}/{id}`.
8. Prueba `GET /api/{entidad}/filter?search=...`.
9. Prueba `DELETE /api/{entidad}/{id}`.

Recomendación: no elimines primero registros que estén siendo referenciados por llaves foráneas, por ejemplo categorías con productos o productos con pedido_items.
