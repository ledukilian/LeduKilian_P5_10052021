<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Core\PDOFactory;

class IndexController extends Controller {
   public function showHome() {
      // $pdoFactory = new PDOFactory();
      // var_dump($pdoFactory);
      // echo '<hr>';
      $postManager = new PostManager();
      // var_dump($postManager);
      // echo '<hr>';
      $test = array(array('name' => 'test', 'order' => 'ASC'), array('name' => 'test2', 'order' => 'DESC'));
      var_dump($postManager->findBy(null, $test, 0, 0));
      $this->render("@client/pages/index.html.twig", []);
   }

   public function showContact() {
      $this->render("@client/pages/contact.html.twig", []);
   }

   public function showPortfolio() {
      $this->render("@client/pages/portfolio.html.twig", []);
   }



}