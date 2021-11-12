<?php
namespace App\Core;

use App\Services\MessageHandler;

class Controller {
   protected $action;
   protected $params;
   protected $twig;
   protected MessageHandler $messageHandler;

   public function __construct($action, $params = NULL) {
      $this->action = $action;
      $this->params = $params;
      $this->twig = new Twig();
      $this->messageHandler = new MessageHandler();
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

   public function redirectToLogin() {
      header('Location: /connexion');
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

   public function redirectToContact() {
      header('Location: /contact');
      exit;
   }

   public function redirectIfNotAdmin() {
      if (!$_SESSION['user']->isAdmin()) {
         header('Location: /');
         exit;
      }
   }

}