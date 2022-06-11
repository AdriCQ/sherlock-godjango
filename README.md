
# Godjango Sherlock 

Sherlock es un servicio de control de Agentes de mensajeria, paqueteria y transporte en un Mapa.

Tiene dos interfaces principales: Interfaz de Agente e Interfaz de Manager.

Es compatible con Web, Android e iOS


## Documentation

[Backend](./backend/README.md)

[GUI](./admin-ui/README.md)


## Scripts de Compilación Rápida

En la carpeta ./scripts hay varios archivos de Compilación para un despliegue rápido

- Light/dark mode toggle
- Live previews
- Fullscreen mode
- Cross platform


## Installation

Instala las dependencias de PHP con Composer.

Dirigete al directorio del proyecto

```bash
    cd ./backend
    composer install
```
## Run Locally

Para ejecutar localmente el proyecto es necesario instalar Node, PHP, Composer, Yarn y Quasar

### Instalar dependencias

Instalar Node
``` bash
    nnn
```

Instalar Yarn y Quasar
``` bash
    npm i -g yarn @quasar/cli
```

Instalar paquetes de PHP
``` bash
    cd ./backend
    composer install
```

Instalar paquetes de Node
``` bash
    cd ./admin-ui
    yarn
```

### Ejecutar Backend local

Para ejecutar el backend es necesario crear el fichero .env

``` bash
    cd ./backend
    cp .env.example .env
    nano .env
```

Completar las VARIABLES DE ENTORNO acorde como se explica mas adelante

Finalmente desde el directorio del backend levantar el servidor ejecutando
``` bash 
    ./serve-local.sh
```
Ya podras ver el servidor en http://localhost:8000

### Ejecutar GUI Local

Para ejecutar la GUI local es necesario tener instalado Node, Yarn y Quasar

Dirigete al directorio de la GUI e instala las dependencias
``` code
    cd ./admin-ui
    yarn
```
Para ver la GUI en modo Develop
``` code
    quasar dev
```
Podras ver la GUI en http://localhost:8080

## Deployment

To deploy this project run on VPS or Locally

```bash
  cd ./admin-ui
  yarn
  quasar build

  cd ../../backend
  ./deploy-backend.sh
```


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`APP_NAME` Nombre de la App

`APP_ENV` Environment de la App

`APP_KEY` Hash unico de la App (php artisan key:generate)

`APP_DEBUG` Booleano

`APP_URL` URL de la App

`DB_CONNECTION` Tipo de conexion (por defecto Postgress)

`DB_HOST` Host de la base de datos

`DB_DATABASE` Nombre de la base de datos

`DB_USERNAME` Usuario de la base de datos

`DB_PASSWORD` Password de la base de datos

`SESSION_DOMAIN` Dominio válido para sesiones (Por defecto coincide con APP_URL)


## License

[MIT](https://choosealicense.com/licenses/mit/)


## Authors

- [@AdriCQ](https://www.github.com/adricq)


