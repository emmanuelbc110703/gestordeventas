# Laravel + Livewire Starter Kit

## Introduction

Our Laravel + [Livewire](https://livewire.laravel.com) starter kit provides a robust, modern starting point for building Laravel applications with a Livewire frontend.

Livewire is a powerful way of building dynamic, reactive, frontend UIs using just PHP. It's a great fit for teams that primarily use Blade templates and are looking for a simpler alternative to JavaScript-driven SPA frameworks like React and Vue.

This Livewire starter kit utilizes Livewire 3, Laravel Volt, TypeScript, Tailwind, and the [Flux UI](https://fluxui.dev) component library.

## Official Documentation

Documentation for all Laravel starter kits can be found on the [Laravel website](https://laravel.com/docs/starter-kits).

## Contributing

Thank you for considering contributing to our starter kit! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel + Livewire starter kit is open-sourced software licensed under the MIT license.


## Instalacion
Primero que nada es necesario clonar el repositorio dentro de tu computadora o servidor, lo puedes hacer con el siguiente comando

Una vez tengas el codigo fuente del proyecto es necesario intalar lo que ```composer``` necesita para funcionar unicamente ejecutando el siguiente comando en tu terminal 
```bashs
composer install
```


Para que las imagenes de tu perfil o de los productos bienes o servicios funcionen es necesario ejecutar el siguiente comando dentro de la terminal
```bash
php artisan storage:link
```

Para confirmar los cambios y limpiar la cache del servidor ejecuta
```bash
php artisan view:clear
```
Ahora puedes correr el servicio con 
```bash
composer run dev
```

