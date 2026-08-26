<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Vue Quasar Template

Una plantilla base para proyectos web que combina Laravel como backend y Vue.js como frontend, con autenticación configurada usando Laravel Fortify.

## Características

-   Laravel 12 con Vue.js 3 y TypeScript
-   Autenticación de usuarios con Laravel Fortify
-   TypeScript configurado
-   Vite para el build del frontend
-   Base de datos SQLite configurada

## Instalación

1. Clona el repositorio:

```bash
git clone <url-del-repositorio>
cd plantilla-laravel-vue
```

2. Instala las dependencias de PHP:

```bash
composer install
```

3. Instala las dependencias de Node.js:

```bash
npm install
```

4. Copia el archivo de configuración:

```bash
cp .env.example .env
```

5. Genera la clave de la aplicación:

```bash
php artisan key:generate
```

6. Ejecuta las migraciones:

```bash
php artisan migrate
```

## Uso

### Opción 1: Desarrollo Local

1. Inicia el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

2. En otra terminal, inicia el servidor de desarrollo de Vite:

```bash
npm run dev
```

3. Visita `http://localhost:8000` en tu navegador.

4. Si en tu equipo tienes instalado composer, puedes iniciar tanto servidor como npm con un solo comando:

```bash
composer run dev
```

### Opción 2: Desarrollo con Docker y Laravel Sail

Laravel Sail proporciona un entorno de desarrollo Docker ligero para ejecutar aplicaciones Laravel.

1. Asegúrate de tener Docker instalado en tu sistema.

2. Inicia los contenedores con Sail:

```bash
./vendor/bin/sail up -d
```

3. En otra terminal, inicia el servidor de desarrollo de Vite:

```bash
npm run dev
```

4. Visita `http://localhost` en tu navegador.

5. Para detener los contenedores:

```bash
./vendor/bin/sail down
```

**Nota:** Si es la primera vez que usas Sail, el comando `sail up` puede tardar varios minutos mientras descarga las imágenes de Docker necesarias.
