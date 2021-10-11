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
         // if ($postManager->insert(new Post($_POST))) {
         //
         // } else {
         //
         // }
         var_dump(new Comment($_POST));
         die;
      }
   }
}



}