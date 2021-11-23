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
      $this->validator = new Validator($_POST);
   }

   public function login() {
      if (!empty($_POST['email'])) {
         $messages = (new Validator($_POST))->checkLogin();
         if (count($messages)==0) {
            $try = $this->userManager->tryLogin();
            if (is_object($try)) {
               $this->messageHandler->addMessage('success', 'Connexion réussie ! Vous êtes maintenant connecté.');
            } else {
               $this->messageHandler->addMessage('danger', $try);
            }
         }
      }
      $this->render("@client/pages/login.html.twig", [
         'messages' => $this->messageHandler,
         'values' => $_POST
      ]);
   }

   public function register() {

      // $test = new MessageHandler();
      // $test->setMessage('success', 'Ceci est un test, évidemment.');
      // $this->redirectToIndex();


      if (!empty($_POST['email'])) {
         $this->validator = new Validator($_POST, new UserManager());
         if ($this->validator->checkRegister()) {
            $user = new User($_POST);
            $user->setDefaultRegistered();
            if ($this->userManager->insert($user)) {
               $this->messageHandler->setMessage('success', 'Création de compte réussie, veuillez vous connecter.');
               $mailer = (new Mailer())->registered($user);
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