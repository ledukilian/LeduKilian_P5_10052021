<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments() {
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
      return $this->transformToPostAndComments($results);
   }

   public function transformToPostAndComments(array $results) {
      $comments = [];
      $post = new Post($results[0]);
      foreach ($results as $element) {
         $user = self::createUser($element);
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
      return $post;
   }

   public function createUser($element) {
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
      return new User($userData);
   }

   public function getPagination() {
      $post_per_page = 6;
      $sql = "SELECT CEIL(COUNT(*)/".$post_per_page.") AS page_count
              FROM post";
      $result = ($this->db)->query($sql)->fetch(PDO::FETCH_ASSOC);
      return [
         'per_page' => $post_per_page,
         'page_count' => $result['page_count']
      ];
   }


}