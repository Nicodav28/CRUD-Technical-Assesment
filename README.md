# Laravel Project Setup

Este documento explica cómo configurar y ejecutar el proyecto Laravel desde cero.

## Requisitos Previos
Asegúrate de tener instalado lo siguiente:
- **PHP** (versión 8.0 o superior)
- **Composer** (https://getcomposer.org/)
- **Laravel** (puedes instalarlo globalmente con `composer global require laravel/installer`)
- **MySQL** o **PostgreSQL**

## 1. Clonar el Repositorio
Clona este repositorio en tu máquina local:
```sh
git clone https://github.com/Nicodav28/CRUD-Technical-Assesment.git
cd CRUD-Technical-Assesment
```

## 2. Instalar Dependencias
Ejecuta el siguiente comando para instalar las dependencias de Laravel:
```sh
composer install
```
## 3. Configurar Variables de Entorno
Copia el archivo de configuración de entorno:
```sh
cp .env.example .env
```
Edita el archivo `.env` y asegúrate de configurar los valores correctos, especialmente la conexión a la base de datos:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_technical_assesment
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

## 4. Generar la Clave de Aplicación
Ejecuta el siguiente comando para generar una clave única para tu aplicación Laravel:
```sh
php artisan key:generate
```

## 5. Ejecutar Migraciones y Seeders
Crea la base de datos y ejecuta las migraciones junto con los seeders:
```sh
php artisan migrate
php artisan db:seed --class=AreaSeeder
php artisan db:seed --class=RoleSeeder
```
Esto creará las tablas y poblará la base de datos con datos de prueba si los seeders están configurados.

## 6. Ejecutar el Servidor de Desarrollo
Inicia el servidor de Laravel con:
```sh
php artisan serve
```
Por defecto, la aplicación se ejecutará en `http://127.0.0.1:8000`

## 7. Acceder a la Aplicación
Ahora puedes acceder a la aplicación en tu navegador en `http://127.0.0.1:8000`

---
Si tienes algún problema, revisa el archivo `.env` y verifica que la base de datos esté corriendo correctamente. 🚀

