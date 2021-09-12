<?php
namespace App\Managers;

use App\Core\Manager;
use PDO;

class CommentManager extends Manager {

   public function getCommentsAndInfos() {
      $sql = "SELECT comment.comment
            , comment.created_at
            , CONCAT(user.firstname, ' ', user.lastname) AS author
            , post.title AS title
            FROM comment
            LEFT JOIN user ON user.id = comment.user_id
            LEFT JOIN post ON post.id = comment.post_id
            ORDER BY comment.created_at DESC
            LIMIT 20";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
   }





}