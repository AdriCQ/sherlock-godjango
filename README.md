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
  - [Editar GUI](#editar-gui)
    - [NodeJS](#instalar-nodejs)
    - [Yarn & Quasar](#instalar-yarn-quasar)
    - [Dependencias de Node](#instalar-dependencias-de-node)
- [Configuracion](#configuracion)
  - [Configuracion Backend](#configuracion-backend)
    - [Permisos de escritura](#permisos-de-escritura)
    - [Variables de Entorno](#variables-de-entorno)
- [Deployment y Compilacion](#deployment-y-compilacion)
  - [Deployment en VPS](#deployment-y-compilacion)
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
  - Postgres SQL | SQLite | MariaDB
- GUI

  - Nodejs
  - Yarn
  - Quasar
  - Android Studio + Android SDK + JDK (Solo para compilar apps)

- Deployment
  - php >= 7.4
  - composer
  - Postgres SQL | SQLite | MariaDB

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

### Editar GUI

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

APP_URL="https://app.domain.com"

DB_CONNECTION=pgsql

DB_HOST=127.0.0.1

DB_DATABASE=sherlock

DB_USERNAME=sherlock

DB_PASSWORD=

SESSION_DOMAIN=${APP_URL}
```

## Deployment y Compilacion

Para el Deployment del proyecto solamente es necesaria la [Instalacion Backend](#instalacion-backend) y la [Configuracion Backend](#configuracion-backend)

### Deployment en VPS

Clona el repositorio en tu VPS y posteriormente [Configura el servidor](#configuracion-backend)

Usa la configuracion de NGINX siguiente reemplazando el `/project-root/` del proyecto y el Dominio

```nginx
  server {
    server_name app.domain.com;
    root /project-root/backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;

    charset utf-8;

#  Optional configure logs

#  access_log /var/log/nginx/app.domain.com-access.log;
#  error_log  /var/log/nginx/app.domain.com-error.log error;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
```

Despues acceder al directorio de backend e inicializar Laravel

```bash
cd /project-root/backend

composer install

php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

O simplemente ejecutar el script de inicializacion `db.init.sh`

```bash
/project-root/backend/db.init.sh
```

### Compilacion Android

Modificar Variables de entorno de la GUI
en `/project-root/admin-ui/.env`

```env
API_SERVER="https://app.domain.com"
```

La compilacion de una app Android o iOS tiene que ser en una PC que tenga Android Studio (Para Android) o XCode (Para iOS).

Es necesaria la [Instalacion de las dependencias de la GUI](#instalacion-gui)

```bash
cd /project-root/admin-ui

yarn build:android
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

## Authors

- [AdriCQ](https://www.github.com/adricq)
