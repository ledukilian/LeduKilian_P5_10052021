<?php
namespace App\Services;

use App\Managers\AdminManager;
use App\Managers\SocialManager;

class TwigGlobals {

   public function getAdmin() {
      $adminManager = new AdminManager();
      return $adminManager->findAdminBy(1);
   }

   public function getSession() {
         return $_SESSION;
   }

   public function getSocials() {
      $socialManager = new SocialManager();
      $socials = $socialManager->findBy(
         [
            'id_admin' => 1
         ]
      );
      if (empty($socials)) {
         return null;
      }
      return $socials;
   }

   public function getPortfolio() {
      $adminManager = new AdminManager();
      $portfolio = $adminManager->findAdminBy(1);
      return $portfolio;
   }




}