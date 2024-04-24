# test-talent-pitch

## Descripción (Description)
1. Español: El proyecto consiste en una plataforma de registro diseñada para programas de retos, donde tanto compañías como usuarios pueden participar activamente. Con esta aplicación, las compañías pueden crear y gestionar desafíos mientras los usuarios se registran y participan en ellos. Proporciona una experiencia interactiva y colaborativa que facilita la organización y seguimiento de los retos, fomentando la participación y la innovación.

2. English: The project consists of a registration platform designed for challenge programs, where both companies and users can actively participate. With this application, companies can create and manage challenges while users register and participate in them. It provides an interactive and collaborative experience that facilitates the organization and tracking of challenges, fostering participation and innovation.

## Dependencias (Dependencies)
1. PHP 8.2*
2. PostgreSQL 15.6*
3. Node 18*
4. ID de Organización de GPT y API KEY (GPT Organization ID and API KEY)

## Instalación (Installation)
1. Clona este repositorio. (Clone this repository)
2. Ejecuta `composer install` para instalar las dependencias de Laravel. (Run `composer install` to install Laravel dependencies.)
3. Ejecuta `npm install` para instalar las dependencias de node en Laravel. (Run `npm install` to install node dependencies in Laravel.)
4. Crea una copia del archivo `.env.example` y renómbrala a `.env`. (Create a copy of the `.env.example` file and rename it to `.env`.)
5. Genera una nueva clave de aplicación ejecutando `php artisan key:generate`. (Generate a new application key by running `php artisan key:generate`.)
6. Configura tu base de datos en el archivo `.env`. (Configure your database in the `.env` file.)
7. Ejecuta las migraciones y los seeders con `php artisan migrate --seed`. (Run migrations and seeders with `php artisan migrate --seed`.)
8. Inicia el servidor de desarrollo con `php artisan serve`. (Start the development server with `php artisan serve`.)

## Prueba (Testing)
1. Ejecuta `./vendor/bin/phpunit` para comenzar el proceso de prueba del proyecto. (Run `./vendor/bin/phpunit` to start testing the project.)
