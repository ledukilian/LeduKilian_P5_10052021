<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Core\PDOFactory;
use App\Managers\UserManager;
use App\Services\Mailer;
use App\Core\Validation\Validator;
use App\Services\MessageHandler;

class IndexController extends Controller {

   public function showHome() {
      $postManager = new PostManager();
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         3
      );
      $this->render("@client/pages/index.html.twig", [
         'posts' => $posts
      ]);
   }

   public function showContact() {
      if (!empty($_POST['email'])) {
         if ($this->validator->checkContact()) {
            $mailer = new Mailer();
            if ($mailer->contact($_POST)) {
               $this->messageHandler->setMessage('success', 'Votre message a bien été envoyé');
            } else {
               $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'envoi de votre message');
            }
            $this->redirectToContact();
         }
      }
      $this->render("@client/pages/contact.html.twig", [
         'messages' => $this->validator->getMessages()
      ]);
   }

   public function showPortfolio() {
      $this->render("@client/pages/portfolio.html.twig", []);
   }

   public function showError() {
      $this->render("@client/errors/error.html.twig", []);
   }

   public function show404() {
      $this->render("@client/errors/404.html.twig", [
         'message' => 'La page que vous recherchez n\'existe pas.'
      ]);
   }



}