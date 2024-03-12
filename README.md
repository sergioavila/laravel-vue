# Aplicación de prueba Canal Cero

Esta es una aplicación web desarrollada con Laravel y Vue.js, utilizando Vuex para la gestión del estado.

## Requisitos

-   PHP >= 7.3
-   Composer
-   Node.js y npm
-   Laravel CLI
-   Vue CLI

## Instalación

1. Clona el repositorio: `git clone https://github.com/sergioavila/laravel-vue`
2. Navega al directorio del proyecto: `cd laravel-vue`
3. Instala las dependencias de PHP con Composer: `composer install`
4. Instala las dependencias de JavaScript con npm: `npm install`
5. Copia el archivo de entorno de ejemplo y configura tus variables de entorno: `cp .env.example .env && nano .env`
6. Es necesario tener una API Key de https://api.cmfchile.cl/
7. Genera una clave de aplicación: `php artisan key:generate`
8. Ejecuta las migraciones de la base de datos: `php artisan migrate`
9. Compila los assets de Vue.js: `npm run dev`

## Uso

Para iniciar el servidor de desarrollo de Laravel, ejecuta: `php artisan serve`

Para compilar los assets de Vue.js y ver los cambios en tiempo real, ejecuta: `npm run watch`

## Características

-   Backend desarrollado con Laravel, proporcionando una API REST para interactuar con la base de datos.
    -   Este código define un controlador en Laravel llamado DataController. Este controlador tiene dos métodos principales: getData y getDataFromApi.
    -   El método getData se encarga de obtener datos de la base de datos y devolverlos como una respuesta JSON. Primero, recibe una solicitud HTTP y extrae los parámetros from y to de la solicitud. Estos parámetros se convierten al formato correcto de fecha y se extraen el año y el mes de cada uno.
    -   Luego, intenta obtener los datos de la base de datos para los años y meses especificados. Si no encuentra datos para el año y mes 'from', llama al método getDataFromApi para obtener los datos de una API, los guarda en la base de datos y luego los recupera de nuevo. Hace lo mismo para el año y mes 'to'.
    -   Finalmente, obtiene todos los datos de la base de datos que están entre las fechas 'from' y 'to' y los devuelve como una respuesta JSON.
    -   El método getDataFromApi se encarga de obtener datos de una API. Primero, obtiene la URL de la API de las variables de entorno. Luego, hace una solicitud GET a la API, pasando el año y el mes como parámetros.
    -   Si la solicitud falla o el código de estado de la respuesta no es 200, devuelve una respuesta JSON con un mensaje de error. Si la solicitud es exitosa, extrae el cuerpo de la respuesta, lo convierte a un array de PHP y verifica si existe la clave 'UFs'. Si existe, devuelve el valor de 'UFs'. Si no existe, devuelve una respuesta JSON con un mensaje de error.
-   Frontend desarrollado con Vue.js, proporcionando una interfaz de usuario interactiva.
    -   El componente App utiliza Vuex para manejar el estado global y vue-chartjs para mostrar los datos en un gráfico de línea. Los datos se obtienen de una API al montar el componente y cada vez que el usuario cambia las fechas seleccionadas.
-   Vuex para la gestión del estado en el frontend, permitiendo un flujo de datos unidireccional y una arquitectura más predecible.
    -   valoresUF es el estado que guarda un array.
    -   UPDATE_UF es una mutación que actualiza valoresUF.
    -   fetchData es una acción que obtiene datos de una API con Axios y luego actualiza valoresUF con los datos obtenidos.
    -   getValoresUF es un getter que devuelve el estado valoresUF.
