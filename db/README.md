# Repo DB - Cafetería con PostgreSQL, Docker y Liquibase

Este repo contiene la base de datos de una cafetería con **5 entidades**:

- Entidades primarias: `categorias`, `productos`.
- Entidades secundarias: `clientes`, `pedidos`, `pedido_items`.

## Estructura

- `01_tables/`: SQL de creación de tablas.
- `09_inserts/`: datos iniciales.
- `11_rollbacks/`: scripts de reversa para Liquibase.
- `liquibase/`: `liquibase.properties`, `changelog-master.xml` y changelogs por archivo SQL.
- `.github/workflows/`: jobs de GitHub Actions.

Las demás carpetas existen con `.gitkeep` para conservar la estructura en Git.

## Levantar PostgreSQL y ejecutar Liquibase

Desde la raíz de este repo:

```bash
cd docker
docker compose -f docker-compose.db.yml up -d postgres
docker compose -f docker-compose.db.yml run --rm liquibase
```

También puedes levantar ambos servicios juntos:

```bash
cd docker
docker compose -f docker-compose.db.yml up
```

## Validar que las tablas quedaron creadas

```bash
docker exec -it cafeteria_postgres psql -U cafeteria_user -d cafeteria_db
\dt
SELECT * FROM categorias;
SELECT * FROM productos;
```

## Rollback con Liquibase

Para devolver los últimos cambiosets:

```bash
cd docker
docker compose -f docker-compose.db.yml run --rm liquibase --defaults-file=liquibase.properties rollbackCount 2
```

## GitHub Actions explicado fácil

GitHub Actions es una automatización que se ejecuta en GitHub cuando haces `push` o abres un `pull request`.

Este repo tiene 2 jobs:

1. **Validar y compilar Liquibase**: levanta una base PostgreSQL temporal en GitHub, ejecuta `liquibase validate` y luego `liquibase update`. Si hay un error en XML, SQL, conexión o constraints, el job falla.
2. **Verificar estructura y archivos SQL**: revisa que existan las carpetas y archivos obligatorios.

Para bloquear merges con errores, entra al repo en GitHub:

1. `Settings`.
2. `Branches`.
3. Crea o edita una regla para `main`.
4. Activa `Require status checks to pass before merging`.
5. Selecciona los checks de este workflow.

Así, si Liquibase falla, GitHub no deja completar el merge del pull request.
