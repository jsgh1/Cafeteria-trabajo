# Repo Frontend - Cafetería Aurora

Frontend en HTML, CSS, JavaScript y Axios.

Incluye:

- `index.html`: landing page/documentación bonita del proyecto.
- `crud.html`: panel CRUD visual conectado al backend.
- `assets/js/app.js`: consumo de endpoints con Axios.
- `assets/css/styles.css`: diseño inspirado en cafetería.

## Ejecutar desde el proyecto completo

```bash
docker compose up --build
```

Frontend:

```text
http://localhost:3000
```

Backend esperado:

```text
http://localhost:8080/api
```

Si cambias el puerto del backend, edita `API_BASE` en `assets/js/app.js`.
