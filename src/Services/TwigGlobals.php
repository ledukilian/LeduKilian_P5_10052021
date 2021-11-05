<?php
namespace App\Services;

use App\Managers\AdminManager;
use App\Managers\SocialManager;

class TwigGlobals {

   public function getAdmin() {
      $adminManager = new AdminManager();
      return $adminManager->findAdminBy($this->getAdminId());
   }

   public function getAdminId() {
      return 1;
   }

   public function getSession() {
      return $_SESSION;
   }

   public function isConnected() {
      return $_SESSION['id'];
   }

   public function getSocials() {
      $socialManager = new SocialManager();
      $socials = $socialManager->findBy(
         [
            'id_admin' => $this->getAdminId()
         ]
      );
      if (empty($socials)) {
         return null;
      }
      return $socials;
   }

   public function getPortfolio() {
      $adminManager = new AdminManager();
      return $adminManager->findAdminBy($this->getAdminId());
   }




}