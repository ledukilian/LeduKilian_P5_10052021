<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;


class AccountController extends Controller {


   public function login() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         if ($userManager->tryLogin()) {
            header('Location: /');
            exit;
         }
      } else {
         $this->render("@client/pages/login.html.twig", []);
      }
   }

   public function register() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         if ($userManager->createUser()) {
            header('Location: /');
            exit;
         }
      } else {
         $this->render("@client/pages/register.html.twig", []);
      }
   }

   public function disconnect() {
      session_destroy();
      header('Location: /');
      exit;
   }









}