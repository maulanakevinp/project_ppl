# Laravel Leaflet JS - SPOT

This is an example project for [Leaflet JS](https://leafletjs.com) and [OpenStreetMap](https://www.openstreetmap.org) built with Laravel 5.8.

![Laravel Leaflet JS Project Example](public/screenshots/Screenshot.png)

## Features

In this project, we have Forest Management (CRUD) with the location / coordinates shown on the map. We also have coordinated entries with direct maps pointing to the Forest Create and Edit forms.

## Installation Steps

Follow this instructions to install the project:

1. Clone this repo.
    ```bash
    $ git clone git@github.com:maulanakevinp/project_ppl.git
    # or
    $ git clone https://github.com/maulanakevinp/project_ppl.git
    ```
2. `$ cd project_ppl`
3. `$ composer install`
4. `$ cp .env.example .env`
5. `$ php artisan key:generate`
6. Set **database config** on `.env` file
7. `$ php artisan migrate --seed`
8. `$ php artisan serve`
10. Open `https://localhost:8000` with browser.

### Leaflet config

We have a `config/leaflet.php` file in this project. Set default **zoom level** and **map center** coordinate here (or in `.env` file).

```php
<?php

return [
    'zoom_level'           => 13,
    'detail_zoom_level'    => 16,
    'map_center_latitude'  => env('MAP_CENTER_LATITUDE', '-3.313695'),
    'map_center_longitude' => env('MAP_CENTER_LONGITUDE', '114.590148'),
];
```

> Please note that this is not an official or required config file from Leaflet JS, it is just a custom config for this project.

## Testing

Run PHPUnit to run feature test:

```bash
$ vendor/bin/phpunit
```

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
