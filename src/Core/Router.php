<?php
namespace App\Core;

use App\Controllers\IndexController;

class Router {
   private $controller;

   public function __construct() {
      $this->setRoute();
   }

   public function getRoute() {
      return $this->controller;
   }

   public function setRoute() {
      try {
         $routes =yaml_parse_file(CONF_DIR."/routes.yml");
      } catch (\Exception $e) {
         echo "Config not found";
      }
      foreach ($routes as $route) {
         if (preg_match('#^' . $route['uri'] . '$#', $_SERVER['REQUEST_URI'], $matches)) {
            $controller = "\\App\\Controllers\\".$route['controller'];
            $params     = array_combine($route['parameters'], array_slice($matches, 1));
            return $this->controller= new $controller($route['action'], $params);
         } else {
            $params     = array_combine($route['parameters'], array_slice($matches, 1));
            return $this->controller= new IndexController('show404', $params);
         }
      }
   }

}