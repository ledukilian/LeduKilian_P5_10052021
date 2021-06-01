<?php
namespace App\Controllers;

use App\Core\Controller;


class CommentController extends Controller {

   public function putOnline() {
      echo 'Mise en ligne';
   }

   public function putOffline() {
      echo 'Mise hors ligne';
   }

}