# Godjango Sherlock GUI

Interfaz de Usuario para los servicios de Godjango Sherlock.

Contiene la GUI de los Managers en una Vista web y permite compilar mediante PWA Quasar + Capacitor una app movil para los Agentes

## Requisitos

Necesario tener instalado Node, Yarn (opcional) y Quasar

Instalar Node

```bash
  npm install my-project
  cd my-project
```

Instalar Yarn

```bash
    npm i -g yarn
```

Instalar Quasar

```bash
    npm i -g @quasar/cli
```

## Complilar

Para el Deployment del proyecto en VPS-Unix

Instalar las dependencias de Node

```bash
    # Usando yarn (recomendado)
    yarn

    # Usando npm
    npm install
```

Instalar Quasar

```bash
    npm i -g @quasar/cli
```

Complilar GUI Web

```bash
    quasar build
```

Complilar APK Android

```bash
    quasar build --mode capacitor --target android --ide
```

Complilar APK iOS

```bash
    quasar build --mode capacitor --target ios --ide
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

## Authors

- [@AdriCQ](https://www.github.com/adricq)
