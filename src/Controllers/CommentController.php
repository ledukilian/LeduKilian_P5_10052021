<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\CommentManager;
use App\Models\Comment;
use App\Services\FormHandler;
use App\Services\MessageHandler;


class CommentController extends Controller {
   protected MessageHandler $messageHandler;
   protected CommentManager $commentManager;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->messageHandler = new MessageHandler();
      $this->commentManager = new CommentManager();
   }

   public function addComment() {
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $comment = new Comment($_POST);
         $comment->setUserId($_SESSION['user']->getId());
         $comment->setStatus(0);
         if ($this->commentManager->insert($comment)) {
            $this->messageHandler->setMessage('success', 'Votre commentaire a bien été pris en compte, il sera traité prochainement');
            header('Location: /blog/'.$this->params['id']);
            exit;
         }
      }
   }

   public function toggleCommentStatus() {
      $comment = $this->commentManager->findOneBy([
         "id" => $this->params['id']
      ]);
      if ($comment->getStatus()==1) {
         $this->messageHandler->setMessage('success', 'Le commentaire a bien été désactivé');
         $comment->setStatus(0);
      } else {
         $this->messageHandler->setMessage('success', 'Le commentaire a bien été activé');
         $comment->setStatus(1);
      }
      if ($this->commentManager->update($comment)) {
         header('Location: /admin/blog/commentaires/');
         exit;
      }

   }



}