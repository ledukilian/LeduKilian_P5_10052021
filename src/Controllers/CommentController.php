<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\CommentManager;
use App\Models\Comment;
use App\Services\FormHandler;


class CommentController extends Controller {

   public function addComment() {
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $commentManager = new CommentManager();
         $comment = new Comment($_POST);
         $comment->setUserId($_SESSION['user']->getId());
         $comment->setStatus(1);
         if ($commentManager->insert($comment)) {
            header('Location: /blog/'.$this->params['slug']);
            exit;
         }
      }
   }

   public function toggleCommentStatus() {
      // TODO : Si commentaire statut = 1 On désactive







   }



}