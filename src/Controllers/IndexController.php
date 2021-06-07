<?php
namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {
   public function showHome() {
      $this->render("@client/pages/index.html.twig", []);

   }

   public function showContact() {
      echo 'Contact.';
      // Ici on ira chercher la vue de contact
   }



}