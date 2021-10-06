<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;


class AccountController extends Controller {
   private String $indexLocation = 'Location: /';

   public function login() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         if ($userManager->tryLogin()) {
            header($this->indexLocation);
            exit;
         }
      } else {
         $this->render("@client/pages/login.html.twig", []);
      }
   }

   public function register() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         $newUser = (new User())->hydrate($_POST);
         if ($userManager->insert($newUser)) {
            header($this->indexLocation);
            exit;
         }
      } else {
         $this->render("@client/pages/register.html.twig", []);
      }
   }

   public function disconnect() {
      session_destroy();
      header($this->indexLocation);
      exit;
   }

   public function getIndexLocation() {

   }







}