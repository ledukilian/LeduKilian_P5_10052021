<?php
namespace App\Core;

class Controller {
   protected $action;

   public function __construct($action) {
      $this->action = $action;
   }

   public function execute() {
      $this->action();
   }
}