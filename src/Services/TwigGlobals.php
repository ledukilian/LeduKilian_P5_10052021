<?php
namespace App\Services;

use App\Managers\AdminManager;

class TwigGlobals {

   public function getAdmin() {
      $adminManager = new AdminManager();
      var_dump($adminManager->findAdminBy(1));
      return $adminManager->findAdminBy(1);
   }

   public function getSession() {
         return $_SESSION;
   }

   public function getSocialNeworks() {
      // New Manager
      // FindAll
   }




}