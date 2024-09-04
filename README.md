# FINANZ APP

Este repositorio contiene un proyecto con arquitectura monolítico.

Este sistema web tiene funcionalidad de agregar finanzas personales para comparar con otros finanzas personales <br/> 
en un cierto periodo de tiempo, puedes observar en forma de gráfica los activos y pasivos de tus finanzas.

# Requerimientos

- PHP 7.4
- Laravel 8.x
- BackPack 4.1
- Bootstrap 4
- MySQL 5.7

# Funcionalidades

- Admin Panel
- Se elimina el sistema Login por defecto de Laravel BackPack
- Se crea vistas personalizadas para Laravel BackPack
- Se crea componentes personalizadas para Laravel BackPack
- Conexión a la base de datos MySQL
- Llaves foráneas en la base de datos MySQL
- Importación de archivos Excel

# Pasos para ejecutar sistema (7 pasos)

Para arrancar el sistema de forma local siga los siguientes pasos:

* Paso 1)

Antes de seguir los pasos asegúrese de crear una base de datos llamado `db_finanzapp` en una base de datos de MySQL.

* Paso 2)

Crear una copia del archivo `.env.example` con nombre `.env` para establecer variables de entorno.

* Paso 3)

Ejecutar el sig. comando para instalar las dependencias para el sistema de Laravel.

```shell
$ composer install
```

* Paso 4)

Ejecutar el sig. comando para generar un token para el sistema de Laravel.

```shell
$ php artisan key:generate
```

* Paso 5)

Ejecutar el sig. comando para ejecutar las migraciones para el sistema de Laravel.

```shell
$ php artisan migrate
```

* Paso 6)

Ejecutar el sig. comando arrancar el sistema de Laravel.

```shell
$ php artisan migrate
```

* Paso 7)

Abre un navegador de su preferencia e ingrese en sig. url para probar el sistema.

```text
http://localhost:8000
```

# Vista Previa

![01.png](/screenshots/01.png)

![02.png](/screenshots/02.png)

![03.png](/screenshots/03.png)

![04.png](/screenshots/04.png)
