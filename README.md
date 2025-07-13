# RodaFramework

RodaFramework is a framework which was build from the scratch. It started with the Udemy Course, [PHP from scratch course](https://www.udemy.com/course/php-from-scratch-course/), which I highly recommend following it, then build and add new stuff into it to improve it for much more wider usage.

## Requirements

At the moment of writting, I was using PHP 8.3.13, but any PHP greater than 8.1 should work. Also composer is required too, however at the moment it can be skipped and replaces with personal [PSR-4 Autoloader](https://www.php-fig.org/psr/psr-4/).

## Installation

Just install composer configuration and it's done.
```
composer install
```
The Database configurations were written with MySQL in mind, however it's not required (and used) to make it run. In case you want to use it and practice, modify `config\db.php` and `Framework\Database.php`.

## Executing

It's very simple, just run the following, then voilà!
```
cd public
php -S localhost:80
```
After that, accessing from browser [localhost](http://localhost:80) will display the main page.

## Basic explanations

Routes are registered into `routes.php`, by explicitally telling method, URI, controller and action.
```
$router->method('/uri', 'Controller@action');
```
Controller must be from `App\\Controllers` namespace, being placed into `App\src\Controllers` folder respecting PSR-4 rule, and be instance of `Framework\\Controllers\\AbstractController.php`.

For sending parameters throw URI, encapsulate the parameter within **{}** with the parameter name. For content body and query parameters they can be extracted throw extention of `Framework\\Controllers\\AbstractController.php`
```
$router->method('/uri/{parameter_name}/details', 'Controller@action');
```
For rendering the page, it is used views and partials. Views represents the main page which are being called throw controller's actions. It can be called throw method `renderView()` if `Framework\\Controllers\\AbstractViewController.php` is extended or `render()` otherwise.
```
$this->renderView('view_name', ['parameter1' => value1, 'parameter2' => value2]);
```
Views respect the following path `App\views\controller\view_name.view.php`, partials respect the following path `App\views\partials\partial_name.php` and base templates respect the following path `App\views\base.view.php`.

`render()` has the following parameters: view which represents the view name, including the controller's name (in this example would be `home\index`), data which are the view data used for rendering, and base template which represents the body of it. Base uses something similar to Twig's template, where we create a basit template for the website, then add the extra content on it depending of the page.

`loadPartial()` is a much more simpler method, requesting partial's name and data to render the partial. In exchange it renders the specific part of the code. They are used in views and template files to render specific parts of the code to avoid repetition.

## Wishes

There could be more missing parts throw this documentation, however I suggest following the course and play around with the code to see for yourself. Have fun :)
