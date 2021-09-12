<?php
namespace App\Managers;

use App\Core\Manager;
use PDO;

class CommentManager extends Manager {

   public function getCommentsAndInfos() {
      $sql = "SELECT comment.id
            , comment.comment
            , comment.status
            , comment.created_at AS createdAt
            , CONCAT(user.firstname, ' ', user.lastname) AS author
            , post.title AS title
            FROM comment
            LEFT JOIN user ON user.id = comment.user_id
            LEFT JOIN post ON post.id = comment.post_id
            ORDER BY comment.created_at DESC
            LIMIT 40";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $results;
   }





}