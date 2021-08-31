<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments(String $slug) {
      $sql = "SELECT post.*, comment.id AS comment_id,
               	comment.created_at AS comment_created_at,
               	comment.updated_at AS comment_updated_at,
               	comment.comment,
               	comment.user_id AS comment_user_id,
               	user.username AS comment_user_username,
               	user.lastname AS comment_user_lastname,
               	user.firstname AS comment_user_firstname,
               	'Hidden' AS comment_user_password,
               	user.email AS comment_user_email,
               	user.role AS comment_user_role,
               	user.created_at AS comment_user_created_at,
               	user.updated_at AS comment_user_updated_at
               FROM post
               INNER JOIN comment ON comment.post_id = post.id AND comment.status = 1
               LEFT JOIN user ON comment.user_id = user.id";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      //$entities = $this->transformToEntities($results);
      $entities = $this->transformToPostAndComments($results);
      return $entities;
      //return $results;
   }

   public function transformToPostAndComments(array $results) {
      $comments = [];
      $post = new Post($results[0]);
      foreach ($results as $element) {
         $userData = [
            'id' => $element['comment_user_id'],
            'username' => $element['comment_user_username'],
            'firstname' => $element['comment_user_firstname'],
            'lastname' => $element['comment_user_lastname'],
            'password' => $element['comment_user_password'],
            'email' => $element['comment_user_email'],
            'role' => $element['comment_user_role'],
            'created_at' => $element['comment_user_created_at'],
            'updated_at' => $element['comment_user_updated_at'],
         ];
         $user = new User($userData);
         $commentData = [
            'id' => $element['comment_id'],
            'user' => $user,
            'user_id' => $element['comment_user_id'],
            'created_at' => $element['comment_created_at'],
            'comment' => $element['comment'],
            'post_id' => $element['id'],
            'status' => 1,
            'updated_at' => $element['comment_updated_at']
         ];
         $comments[] = new Comment($commentData);
      }
      $post->setComments($comments);
      // 🟢 Mentorat
      var_dump($post);
      die;
      // var_dump($post->getComments());
      // die;
      return $post;
   }




}