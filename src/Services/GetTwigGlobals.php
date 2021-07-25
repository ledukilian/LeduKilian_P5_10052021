<?php
namespace App\Services;

use App\Managers\AdminManager;

class GetTwigGlobals {

   public function getAdmin() {
      $adminManager = new AdminManager();
      return $adminManager->findOneBy(
         [
            'id' => 1
         ]);
   }






}