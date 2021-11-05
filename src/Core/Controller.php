<?php
namespace App\Core;

class Controller {
   protected $action;
   protected $params;
   protected $twig;

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

   public function redirectToIndex() {
      header('Location: /');
      exit;
   }

   public function redirectToAdmin() {
      header('Location: /admin/');
      exit;
   }

   public function redirectToSocial() {
      header('Location: /admin/reseaux/');
      exit;
   }

   public function redirectIfNotAdmin() {
      if (!$_SESSION['user']->isAdmin()) {
         header('Location: /');
         exit;
      }
   }

}