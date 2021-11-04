<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\CommentManager;
use App\Models\Comment;
use App\Services\FormHandler;
use App\Services\MessageHandler;


class CommentController extends Controller {

   public function addComment() {
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $commentManager = new CommentManager();
         $messageHandler = new MessageHandler();
         $comment = new Comment($_POST);
         $comment->setUserId($_SESSION['user']->getId());
         $comment->setStatus(0);
         if ($commentManager->insert($comment)) {
            $messageHandler->setMessage('success', 'Votre commentaire a bien été pris en compte, il sera traité prochainement');
            header('Location: /blog/'.$this->params['id']);
            exit;
         }
      }
   }

   public function toggleCommentStatus() {
      $commentManager = new CommentManager();
      $messageHandler = new MessageHandler();
      $comment = $commentManager->findOneBy([
         "id" => $this->params['id']
      ]);
      if ($comment->getStatus()==1) {
         $messageHandler->setMessage('success', 'Le commentaire a bien été désactivé');
         $comment->setStatus(0);
      } else {
         $messageHandler->setMessage('success', 'Le commentaire a bien été activé');
         $comment->setStatus(1);
      }
      if ($commentManager->update($comment)) {
         header('Location: /admin/blog/commentaires/');
         exit;
      }

   }



}