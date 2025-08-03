# RodaFramework

**RodaFramework** is a PHP framework built entirely from scratch. It originated from the Udemy course [PHP from scratch course](https://www.udemy.com/course/php-from-scratch-course/), which I highly recommend. From there, I expanded and improved it to support broader use cases.


## Requirements

At the time of writing, I was using **PHP 8.3.13**, but any version **PHP ≥ 8.1** should work. Composer is required, although it can be skipped if you prefer to use a personal [PSR-4 Autoloader](https://www.php-fig.org/psr/psr-4/).

## Installation

Run the following command to install dependencies via Composer:
```
composer install
```
Database configuration is set up for MySQL, but using a database is not required to run the framework. If you'd like to enable it for practice, update the settings in `App\\config\\db.php` and use the classes insideo of `Framework\\Database` folder.

## Running the App

It's very simple, just run the following, then voilà!
```
cd public
php -S localhost:80
```
After that, visit [localhost](http://localhost:80) on your browser.

## Basic Concepts

### Routing

Routes are defined in `routes.php`. Each route includes the HTTP method, URI, controller action, and (optionally) the required user role:
```
$router->method('/uri', 'Controller@action', 'role');
```
Controllers must belong to the App\Controllers namespace and be located in App\src\Controllers, following PSR-4.
Controller must belong to the `App\\Controllers` namespace and be located in `App\src\Controllers`, following PSR-4.

They must also extend `Framework\\Controllers\\AbstractController.php`.

For dynamic routes, use curly braces to define parameters:
```
$router->method('/uri/{parameter_name}/details', 'Controller@action');
```
Request body and query parameters can be accessed through the base controller.

### Views and Partials

Pages are rendered using views and partials.

- `renderView()` is available if your controller extends `Framework\\Controllers\\AbstractViewController`
- Otherwise, use render()

```
$this->renderView('view_name', ['parameter1' => value1, 'parameter2' => value2]);
```

**Path Conventions:**

- Views: `App\\views\\controller\\view_name.view.php`
- Partials: `App\\views\\partials\\partial_name.php`
- Base templates: `App\\views\\base.view.php`

`render()`

Parameters:
- name: View name, like 'home/index'
- data: Array of view data
- base: Optional base template

The system uses a layout structure similar to Twig — a reusable base template with injected content per page.

`loadPartial()`

Parameters:
- name: Partial name, like 'home/index'
- data: Array of view data

Used in views and templates to reuse repeated sections (e.g., headers, forms).

### Dependency Injection

Services, Controllers and special parameters are defined in `App\\config\\di.php`.
```
Class_Name_or_Alias => [
    'class' => Class_Name,
    'method' => Static_Method,
    'args' => [
        'argument_1',
        'Class_Name_Argument_2',
    ]
]
```

- **class**: Required if using an alias, abstract, or interface
- **method**: Optional — used if instantiation doesn’t happen through the constructor
- **args**: Arguments passed to the constructor or method

You can override any services defined in `Framework\\config\\di.php` by redefining them in `App\\config\\di.php`.

**NOTE:** The only class that cannot be overridden is `Framework\\DependencyInjection\\Container`.

### Configuration Files

Configuration files are stored in `App\\config` folder. They help automate common setups and keep settings easy to locate.

Currently supported config files:
- Dependency Injection
- Database
- Logger
- Session

To use a custom configuration reader, define your own implementation of `Framework\\ConfigReader\\IConfigReader` in your DI file.

## License

This project is licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute it for any purpose — including commercial use — as long as you include the original license and copyright notice.

You cannot claim ownership of the original work, but you may use it in open-source or personal projects freely.

## Wishes

This framework was done as a fun challenge for myself, to try to imagine how other frameworks work behind the scene and integrate as much as I can inside of it. Have fun :)
