<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;
use App\Models\User;
use App\Services\MessageHandler;


class AccountController extends Controller {
   protected MessageHandler $messageHandler;
   protected UserManager $userManager;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->messageHandler = new MessageHandler();
      $this->userManager = new UserManager();
   }

   public function login() {
      if (isset($_POST['email'])) {
         if ($this->userManager->tryLogin()) {
            $this->messageHandler->setMessage('success', 'Connexion réussie ! Vous êtes maintenant connecté.');
            header($this->getIndexLocation());
            exit;
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'authentification.');
         }
      }
      $this->render("@client/pages/login.html.twig", []);
   }

   public function register() {
      if (isset($_POST['email'])) {
         $userToCreate = new User($_POST);
         $userToCreate->setRole("USER");
         $userToCreate->setPasswordHashed($userToCreate->getPassword());
         if ($this->userManager->insert($userToCreate)) {
            $this->messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
            header($this->getIndexLocation());
            exit;
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'inscription.');
         }
      }
      $this->render("@client/pages/register.html.twig", []);
   }

   public function disconnect() {
      $this->messageHandler->setMessage('success', 'Déconnexion réussie, vous êtes bien déconnecté');
      session_destroy();
      header($this->getIndexLocation());
      exit;
   }






}