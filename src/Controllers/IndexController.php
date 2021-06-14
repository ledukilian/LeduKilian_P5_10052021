<?php
namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {
   public function showHome() {
      $this->render("@client/pages/index.html.twig", []);
   }

   public function showContact() {
      $this->render("@client/pages/contact.html.twig", []);
   }
   
   public function showPortfolio() {
      $this->render("@client/pages/portfolio.html.twig", []);
   }



}