<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\CommentManager;
use App\Models\Comment;
use App\Services\FormHandler;


class CommentController extends Controller {

   public function toggleCommentStatus() {
      // TODO : Si commentaire statut = 1 On désactive







   }

public function addComment() {
   if (isset($_POST)) {
      if ((new FormHandler())->checkform($_POST)) {
         $commentManager = new CommentManager();
         $_POST['_userId'] = $_SESSION['user']->getId();
         $_POST['_status'] = 1;
         if ($commentManager->insert(new Comment($_POST))) {
            var_dump('Réussi');
         } else {
            var_dump('Echec');
         }
      }
   }
}



}