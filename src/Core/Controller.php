<?php
namespace App\Core;

class Controller {
   protected $action;
   protected $params;
   protected $twig;
   private String $indexLocation = 'Location: /';

   public function __construct($action, $params = NULL) {
      $this->action = $action;
      $this->params = $params;
      $this->twig = new Twig();
   }

   public function execute() {
      $method = $this->action;
      $this->$method();
   }

   public function render($template, $array) {
      echo $this->twig->twigRender($template, $array);
   }

   public function getIndexLocation() {
      return $this->indexLocation;
   }

   public function redirectIfNotAdmin() {
      if (!$_SESSION['user']->isAdmin()) {
         header($this->getIndexLocation());
         exit;
      }
   }

}