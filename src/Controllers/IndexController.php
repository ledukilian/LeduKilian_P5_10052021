<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;

class IndexController extends Controller {
   public function showHome() {
      var_dump('test');
      echo '<hr>';
      $postManager = new PostManager();
      var_dump($postManager);
      echo '<hr>';
      $postManager->findAll();
      echo '<hr>';
      var_dump($postManager);
      //$this->render("@client/pages/index.html.twig", []);
   }

   public function showContact() {
      $this->render("@client/pages/contact.html.twig", []);
   }

   public function showPortfolio() {
      $this->render("@client/pages/portfolio.html.twig", []);
   }



}