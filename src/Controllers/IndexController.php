<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Core\PDOFactory;
use App\Managers\UserManager;

class IndexController extends Controller {
   public function showHome() {
      $postManager = new PostManager();
      $testObject = $postManager->findOneBy(
         [
            'id' => 1
         ]
      );
      $postManager->insert($testObject);



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
      $this->render("@client/pages/contact.html.twig", []);
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