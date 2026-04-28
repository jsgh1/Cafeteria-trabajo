# Cafetería Aurora - Proyecto completo

Este zip contiene los 3 módulos funcionando juntos:

- `db/`: PostgreSQL + Liquibase + datos iniciales + rollbacks + GitHub Actions.
- `backend/`: API PHP CRUD con Swagger.
- `frontend/`: landing page y CRUD visual en HTML, CSS, JS y Axios.

## Levantar todo con Docker

Desde la raíz del proyecto:

```bash
docker compose up --build
```

Servicios:

- PostgreSQL: `localhost:5432`
- Backend API: `http://localhost:8080`
- Swagger: `http://localhost:8080/docs`
- Frontend: `http://localhost:3000`

## Orden de arranque

1. Docker levanta PostgreSQL.
2. Liquibase espera a que PostgreSQL esté saludable.
3. Liquibase crea tablas e inserta datos iniciales.
4. Backend espera a que Liquibase termine bien.
5. Frontend queda disponible para usar el CRUD visual.

## Comandos útiles

Ver logs:

```bash
docker compose logs -f
```

Detener:

```bash
docker compose down
```

Borrar volumen y reiniciar la base desde cero:

```bash
docker compose down -v
docker compose up --build
```

Entrar a PostgreSQL:

```bash
docker exec -it cafeteria_postgres psql -U cafeteria_user -d cafeteria_db
```

## Probar los 30 endpoints en Swagger

Abre `http://localhost:8080/docs` y prueba por entidad:

1. `GET /api/{entidad}` listar.
2. `POST /api/{entidad}` crear.
3. `GET /api/{entidad}/{id}` consultar por ID.
4. `PUT /api/{entidad}/{id}` actualizar.
5. `GET /api/{entidad}/filter?search=texto` filtrar.
6. `DELETE /api/{entidad}/{id}` eliminar.

Entidades: `categorias`, `productos`, `clientes`, `pedidos`, `pedido_items`.