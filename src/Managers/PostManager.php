<?php
namespace App\Managers;

use App\Core\Manager;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments(String $slug) {
      $sql = "SELECT post.*, comment.id AS comment_id,
               comment.created_at AS comment_created_at,
               comment.updated_at AS comment_updated_at,
               comment.comment
              FROM post
              LEFT JOIN comment ON comment.post_id = post.id AND comment.status = 1";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      //$entities = $this->transformToEntities($results);
      var_dump($results);
      return $results;
   }





}