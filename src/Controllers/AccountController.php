<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;
use App\Models\User;
use App\Services\MessageHandler;
use App\Core\Validation\Validator;
use App\Services\Mailer;

class AccountController extends Controller {
   protected MessageHandler $messageHandler;
   protected UserManager $userManager;
   protected Validator $validator;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->messageHandler = new MessageHandler();
      $this->userManager = new UserManager();
   }

   public function login() {
      if (!empty($_POST['email'])) {
         if ((new Validator($_POST))->checkLogin()) {
            $try = $this->userManager->tryLogin();
            if (is_object($try)) {
               $this->messageHandler->setMessage('success', 'Connexion réussie ! Vous êtes maintenant connecté.');
               $this->redirectToIndex();
            } else {
               $this->messageHandler->setMessage('danger', $try);
               $this->redirectToSelf();
            }
         } else {
            $this->redirectToSelf();
         }
      }
         $this->render("@client/pages/login.html.twig", []);
      }

   public function register() {
      if (!empty($_POST['email'])) {
         if ((new Validator($_POST, new UserManager()))->checkRegister()) {
            $user = new User($_POST);
            $user->setRole("USER");
            $user->setPasswordHashed($user->getPassword());
            if ($this->userManager->insert($user)) {
               $this->messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
               $mailer = (new Mailer())->registered($user);
               $this->redirectToIndex();
            } else {
               $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'inscription.');
               $this->redirectToSelf();
            }
         } else {
            $this->redirectToSelf();
         }
      }
      $this->render("@client/pages/register.html.twig", []);
   }

   public function disconnect() {
      session_destroy();
      $this->redirectToIndex();
   }






}