<?php
namespace App\Core;

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
         $routes = Yaml::parseFile(CONF_DIR."/routes.yml")
      } catch (\Exception $e) {
         echo "Config not found";
      }
      foreach ($routes as $route) {
         if (preg_match('#^' . $route['uri'] . '$#', $_SERVER['REQUEST_URI'], $matches)) {
            $controller = "App/Controllers/".$route['controller'];
            return $this->controller= new $controller($route['action']);
         }
      }
   }

}