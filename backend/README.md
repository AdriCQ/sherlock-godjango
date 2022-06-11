
# API Godjango Sherlock

API para los servicios de Godjango Sherlock
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


## Deployment

Para el Deployment de la API llenar las variables de entorno en el fichero .env y ejecutar

Garantizar permisos de escritura 
```bash
    sudo chmod -R 775 storage
    sudo chown -R $USER:www-data storage
```
Ejecutar script de despliegue
```bash
    ./deploy.sh
```


## API Reference

#### Users: Create
``` http
POST /api/users
Authorization: API_TOKEN

{
    "name": string,
    "email": string,
    "phone": string|number,
    "password": string,
    "password_confirmation": string
}
```

#### Users: List

``` http
GET /api/users/list
Authorization: API_TOKEN
```
#### Users: Auth Login
``` http
POST /api/users/login

{
    "email": string,
    "password": string,
}
```

#### Users: Me
``` http
GET /api/users
Authorization: API_TOKEN
```

#### Users: Update password
``` http
PATCH /api/users/{userId}
Authorization: API_TOKEN

{
    "current_password": string,
    "password": string,
    "password_confirmation": string
}
```

#### Agents: Create
``` http
POST /api/agents
Authorization: API_TOKEN

{
    "address": string,
    "others": string,
    "nick": string,
    "categories": array,
    "position": {
        "lat": number,
        "lng": number
    },
    "user_id": number,
    "agent_group_id": number
}
```
#### Agents FIND
``` http
GET /api/agents/{agent_id}
Authorization: API_TOKEN
```

#### Agents List
``` http
GET /api/agents
Authorization: API_TOKEN
```

#### Agents Remove
``` http
DELETE /api/agents/{agent_id}
Authorization: API_TOKEN
```

#### Agents Update
``` http
PATCH /api/agents/{agent_id} 
Authorization: API_TOKEN

{
    "address": string,
    "others": string,
    "nick": string,
    "categories": array,
    "position": {
        "lat": number,
        "lng": number
    },
    "user_id": number,
    "agent_group_id": number,
    "bussy: boolean
}
```

#### Agents SEARCH
``` http
GET /api/agents/search
Authorization: API_TOKEN

{
    "mode": string,
    "search": string
}
```

#### Agents Me
``` http
GET /api/agents/whoami 
Authorization: API_TOKEN
```

## License

[MIT](https://choosealicense.com/licenses/mit/)


## Autores

- [@AdriCQ](https://www.github.com/adricq)
