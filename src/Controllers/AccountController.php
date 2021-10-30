<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;
use App\Models\User;
use App\Services\MessageHandler;


class AccountController extends Controller {

   public function login() {
      if (isset($_POST['email'])) {
         $messageHandler = new MessageHandler();
         $userManager = new UserManager();
         if ($userManager->tryLogin()) {
            $messageHandler->setMessage('success', 'Connexion réussie ! Vous êtes maintenant connecté.');
            header($this->getIndexLocation());
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'authentification.');
         }
      } else {
         $this->render("@client/pages/login.html.twig", []);
      }
   }

   public function register() {
      if (isset($_POST['email'])) {
         $messageHandler = new MessageHandler();
         $userManager = new UserManager();
         $userToCreate = new User($_POST);
         $userToCreate->setRole("USER");
         $userToCreate->setPasswordHashed($userToCreate->getPassword());
         if ($userManager->insert($userToCreate)) {
            $messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
            header($this->getIndexLocation());
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'inscription.');
         }
      } else {
         $this->render("@client/pages/register.html.twig", []);
      }
   }

   public function disconnect() {
      $messageHandler = new MessageHandler();
      $messageHandler->setMessage('success', 'Déconnexion réussie, vous êtes bien déconnecté');
      session_destroy();
      header($this->getIndexLocation());
      exit;
   }






}