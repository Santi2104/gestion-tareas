# Sistema de Gestión de Tareas

Aplicación web fullstack para la gestión de tareas desarrollada con **Laravel 12**, **Vue 3 + TypeScript**, **Quasar Framework** y **MariaDB**.

---

## Requisitos Previos

- [Docker](https://docs.docker.com/get-docker/) y [Docker Compose](https://docs.docker.com/compose/) instalados en el sistema.

---

## Inicio Rápido (Modo Demo / Producción)

Para levantar toda la aplicación en un solo paso (con assets compilados, servidor web Nginx, backend PHP-FPM, MariaDB y datos de prueba sembrados automáticamente):

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

Una vez completado el arranque, abre tu navegador en:

**[http://localhost:8080](http://localhost:8080)**

### Credenciales de Acceso (Usuario de Prueba)

- **Email:** `test@example.com`
- **Contraseña:** `password`

_(También puedes registrar un nuevo usuario desde la pantalla de registro)._

Para detener los contenedores:

```bash
docker compose -f docker-compose.prod.yml down
```

---

## Modo Desarrollo (Laravel Sail)

Si deseas trabajar en desarrollo local:

1. **Copiar el archivo de entorno:**

    ```bash
    cp .env.example .env
    ```

2. **Instalar dependencias de PHP (si no cuentas con Composer local):**

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
    ```

    _(O directamente `composer install` si tienes PHP/Composer instalado)._

3. **Iniciar los servicios con Sail:**

    ```bash
    ./vendor/bin/sail up -d
    ```

4. **Generar la clave de la aplicación:**

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

5. **Instalar dependencias de Node.js:**

    ```bash
    ./vendor/bin/sail npm install
    ```

6. **Ejecutar migraciones y seeders:**

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

7. **Iniciar el servidor de desarrollo de Vite:**

    ```bash
    ./vendor/bin/sail npm run dev
    ```

8. Acceder en **[http://localhost](http://localhost)**.
