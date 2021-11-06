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
         $try = $this->userManager->tryLogin();
         if (is_object($try)) {
            $this->messageHandler->setMessage('success', 'Connexion réussie ! Vous êtes maintenant connecté.');
            $this->redirectToIndex();
         } else {
            $this->messageHandler->setMessage('danger', $try);
            $this->redirectToLogin();
         }
      }
      $this->render("@client/pages/login.html.twig", []);
   }

   public function register() {
      if (isset($_POST['email'])) {
         $user = new User($_POST);
         $user->setRole("USER");
         $user->setPasswordHashed($user->getPassword());
         if ($this->userManager->insert($user)) {
            $this->messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
            $this->redirectToIndex();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'inscription.');
         }
      }
      $this->render("@client/pages/register.html.twig", []);
   }

   public function disconnect() {
      session_destroy();
      $this->redirectToIndex();
   }






}