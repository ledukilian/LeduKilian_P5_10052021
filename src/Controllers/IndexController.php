<?php
namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {
   public function showHome() {
      echo 'Home.';
      // Ici on ira chercher la vue de l'accueil
   }

   public function showContact() {
      echo 'Contact.';
      // Ici on ira chercher la vue de contact
   }



}