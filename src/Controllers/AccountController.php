<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;
use App\Models\User;


class AccountController extends Controller {

   public function login() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         if ($userManager->tryLogin()) {
            header($this->getIndexLocation());
            exit;
         }
      } else {
         $this->render("@client/pages/login.html.twig", []);
      }
   }

   public function register() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         $userToCreate = new User($_POST);
         $userToCreate->setRole("USER");
         $userToCreate->setPasswordHashed($userToCreate->getPassword());
         if ($userManager->insert($userToCreate)) {
            header($this->getIndexLocation());
            exit;
         }
      } else {
         $this->render("@client/pages/register.html.twig", []);
      }
   }

   public function disconnect() {
      session_destroy();
      header($this->getIndexLocation());
      exit;
   }






}