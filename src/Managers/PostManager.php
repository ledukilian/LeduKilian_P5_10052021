<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Post;
use App\Models\Comment;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments(String $slug) {
      $sql = "SELECT post.*, comment.id AS comment_id,
               comment.created_at AS comment_created_at,
               comment.updated_at AS comment_updated_at,
               comment.comment,
               comment.user_id AS comment_user_id
              FROM post
              LEFT JOIN comment ON comment.post_id = post.id AND comment.status = 1";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      //$entities = $this->transformToEntities($results);
      $entities = $this->transformToPostAndComments($results);
      return $entities;
      //return $results;
   }

   public function transformToPostAndComments(array $results) {
      $comments = [];
      $post = new Post($results[0]);
      foreach ($results as $comment) {
         if(!is_null($comment['comment_id'])) {
            $comment['id'] = $comment['comment_id'];
            unset($comment['comment_id']);
            $comment['created_at'] = $comment['comment_created_at'];
            unset($comment['comment_created_at']);
            $comment['updated_at'] = $comment['comment_updated_at'];
            unset($comment['comment_updated_at']);
            $comment['user_id'] = $comment['comment_user_id'];
            unset($comment['comment_user_id']);
            $comments[] = new Comment($comment);
         }
      }
      $post->setComments($comments);
      var_dump($post);
      die;
      return $post;
   }




}