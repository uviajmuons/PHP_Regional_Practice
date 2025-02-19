<?php 
class Router {
  static $routes = [];
  static function path($reqM, $uri, $hdl) {
    $uri = preg_replace('#\{(.*?)\}#', '([^\/]+)', $uri);
    self::$routes[] = [$reqM, "#^$uri$#", $hdl];
  }

  static function handleRequest() {
    $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
    $REQUEST_URI = $_SERVER['REQUEST_URI'];

    foreach (self::$routes as $route) {
      [$reqM, $uri, $hdl] = $route;
      if ($reqM !== $REQUEST_METHOD) continue;
      if (preg_match($uri, $REQUEST_URI, $matches)) {
        array_shift($matches);
        call_user_func_array($hdl, $matches);
        return 'found';
      }
    }
    move('/', "wrong URI: $uri");
  }
}

function get($uri, $hdl) {
  Router::path('GET', $uri, $hdl);
}

function post($uri, $hdl) {
  Router::path('POST', $uri, $hdl);
}