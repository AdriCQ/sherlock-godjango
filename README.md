
# Godjango Sherlock

Sherlock es un servicio de control de Agentes de mensajeria, paqueteria y transporte en un Mapa.

Tiene dos interfaces principales: Interfaz de Agente e Interfaz de Manager.

Es compatible con Web, Android e iOS

## Indice

- [Inicio](#godjango-sherlock)
- [Requisitos](#requisitos)
- [Instalacion](#instalacion)
  - [Instalacion Backend](#instalacion-backend)
    - [Librerias de PHP](#instalar-las-dependencias-de-php)
    - [Composer](#instalar-composer)
    - [Dependencias de composer](#instalar-dependencias-de-composer)
  - [Instalacion GUI](#instalacion-gui)
    - [NodeJS](#instalar-nodejs)
    - [Yarn & Quasar](#instalar-yarn-quasar)
    - [Dependencias de Node](#instalar-dependencias-de-node)
- [Configuracion](#configuracion)
  - [Configuracion Backend](#configuracion-backend)
    - [Permisos de escritura](#permisos-de-escritura)
    - [Variables de Entorno](#variables-de-entorno)
  - [Configuracion GUI](#configuracion-gui)
    - [Dominio de la API](#dominio-de-la-api)
- [Deployment y Compilacion](#deployment-y-compilacion)
  - [Deployment en VPS](#deployment-en-vps)
  - [Compilacion Android](#compilacion-android)
- [Referencias](#documentation)
  - [Backend](./backend/README.md)
  - [GUI](./admin-ui/README.md)
- [License](#license)
- [Authors](#authors)

## Requisitos
- Backend
  - php >= 7.4
  - composer
  - Laravel 8
  - Postgres SQL
  
- GUI
  - Nodejs
  - Yarn
  - Quasar
  - Android Studio + Android SDK + JDK (Solo para compilar apps)

- Deployment
  - php >= 7.4
  - composer
  - Laravel 8
  - Postgres SQL

## Instalacion
### Instalacion Backend
#### Instalar las dependencias de PHP.

`Si ya tienes Laravel 8 puedes omitir este paso`

```bash
apt install -y php7.4-fpm php7.4-mysql php7.4-mbstring php7.4-xml php7.4-bcmath php7.4-pgsql
```
#### Instalar Composer

`Si ya tienes Laravel 8 puedes omitir este paso`

```bash
cd ~

curl -sS https://getcomposer.org/installer -o composer-setup.php

HASH=`curl -sS https://composer.github.io/installer.sig`

php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; 

unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

#### Instalar dependencias de composer

```bash
cd /project-root/backend

composer install
```

### Instalacion GUI

#### Instalar NodeJS

`Si ya tienes NodeJs puedes omitir este paso`

```bash
sudo apt install nodejs
```

#### Instalar Yarn Quasar

```bash
npm i -g yarn @quasar/cli
```

#### Instalar dependencias de Node
```bash
cd /project-root/admin-ui

yarn
```
## Configuracion

### Configuracion backend

#### Permisos de escritura
```bash
sudo chmod -R 775 storage
sudo chown -R $USER:www-data storage
```

#### Variables de Entorno
`Editar fichero /project-root/backend/.env`
```code
APP_NAME="Sherlock Godjango"

APP_ENV=local

APP_KEY=(php artisan key:generate)

APP_DEBUG=true

APP_URL="https://URL-TO-PROJECT"

DB_CONNECTION=pgsql

DB_HOST=127.0.0.1

DB_DATABASE=sherlock

DB_USERNAME=sherlock

DB_PASSWORD=

SESSION_DOMAIN=${APP_URL}
```

### Configuracion GUI

#### Dominio de la API
`Editar fichero /project-root/admin-ui/src/boot/axios.ts`
```code
...

/**
 * @const baseURL URl de la API
 */
const baseURL = 'https://godjango-test.servimav.com';

...

```


## Deployment y Compilacion

Para el Deployment del proyecto solamente es necesaria la [Instalacion Backend](#instalacion-backend) y la [Configuracion Backend](#configuracion-backend)


### Deployment en VPS
```bash
cd /project-root/backend

php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

### Compilacion Android

La compilacion de una app Android o iOS tiene que ser en una PC que tenga Android Studio (Para Android) o XCode (Para iOS).

Es necesaria la [Instalacion de las dependencias de la GUI](#instalacion-gui)

```bash
cd /project-root/admin-ui

quasar build --mode capacitor --target [android|ios] --ide
```

## License

[MIT](https://choosealicense.com/licenses/mit/)


## Authors

- [AdriCQ](https://www.github.com/adricq)


