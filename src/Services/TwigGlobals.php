<?php
namespace App\Services;

use App\Managers\AdminManager;

class TwigGlobals {

   public function getAdmin() {
      $adminManager = new AdminManager();
      return $adminManager->findOneBy(
         [
            'id' => 1
         ]);
      // return $adminManager->findAdminBy(
      //    [
      //       'id' => 1
      //    ]);
   }

   public function getSession() {
      if (isset($_SESSION)) {
         return $_SESSION;
      } else {
         return false;
      }
   }






}