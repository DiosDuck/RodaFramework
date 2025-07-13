<?php

/**
 * Get the base path
 */
function basePath(string $path = ''): string
{
   return __DIR__ . '/' . $path;
}

/**
 * Load a partial
 */
function loadPartial(string $name, array $data = []): void
{
   $partialPath = basePath("App/views/partials/{$name}.php");

   if (file_exists($partialPath)) {
      extract($data);
      require $partialPath;
   } else {
      echo "Partial '{$name}' not found!";
   }
}

/**
 * Render the vie
 */
function render(string $view, array $data = [], string $base = 'base'): void
{
   $viewPath = basePath("App/views/{$view}.view.php");
   if (file_exists($viewPath)) {
      extract($data);

      /* convert the view into a string then pass it to the base */
      ob_start();
      require $viewPath;
      $body = ob_get_clean();

      $basePath = basePath("App/views/{$base}.view.php");
      if (file_exists($basePath)) {
         require $basePath;
      } else {
         echo "Base path '{$basePath}' does not exist";
      }
   }
}

/**
 * Inspect a value(s)
 */
function inspect(mixed $value): void 
{
   echo '<pre>';
   var_dump($value);
   echo '</pre>';
}

/**
 * Inspect a value(s) and die
 */
function inspectAndDie(mixed $value): void 
{
   echo '<pre>';
   var_dump($value);
   echo '</pre>';
   die();
}

/**
 * Sanitize Data
*/
function sanitize(string $dirty): string 
{
   return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to a give url
 */
function redirect(string $url): void 
{
   header("Location: $url");
   exit;
}

/**
 * Converts the data into JSON body and sends it
 */
function sendJson(array $data, int $code = 200): void 
{
   header('Content-Type: application/json; charset=utf-8');
   http_response_code($code);
   echo json_encode($data);
   exit;
}

/**
 * Set response code (this one is used for views,
 * since for API is set on sendJson)
 * @see sendJson
 */
function setResponseCode(int $code = 200): void
{
   http_response_code($code);
}
