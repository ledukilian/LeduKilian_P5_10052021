<?php
namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller {
   public function showHome() {
      echo 'Home.';
   }

   public function showContact() {
      echo 'Contact.';
   }



}