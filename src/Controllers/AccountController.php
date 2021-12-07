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
   protected UserManager $userManager;
   protected Mailer $mailer;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->userManager = new UserManager();
      $this->validator = new Validator($_POST);
      $this->mailer = new Mailer();
   }

   public function login() {
      if (!empty($_POST['email']) && $this->validator->checkLogin()) {
         $try = $this->userManager->tryLogin();
         if (is_object($try)) {
            $this->messageHandler->setMessage('success', 'Connexion réussie, bon retour parmi nous '.$try->getFirstName().' !');
            $this->redirectToIndex();
         } else {
            $this->messageHandler->setMessage('danger', $try);
            header('Location: /connexion');
            exit;
         }
      }
      $this->messageHandler->addMessages($this->validator->getMessages());
      $this->render("@client/pages/login.html.twig", [
         'messages' => $this->messageHandler->getMessages()
      ]);
   }

   public function register() {
      if (!empty($_POST['email'])) {
         $this->validator = new Validator($_POST, new UserManager());
         if ($this->validator->checkRegister()) {
            $user = (new User($_POST))->setDefaultRegistered();
            if ($this->userManager->insert($user)) {
               $this->messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
               $this->mailer->registered($user);
               $this->redirectToIndex();
            }
         }
      }
      $this->render("@client/pages/register.html.twig", [
         'messages' => $this->validator->getMessages()
      ]);
   }

   public function disconnect() {
      session_destroy();
      $this->redirectToIndex();
   }






}