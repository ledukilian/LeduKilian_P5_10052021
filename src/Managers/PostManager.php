<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Admin;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments($slug) {
      $sql = "SELECT post.*, comment.id AS comment_id, comment.created_at AS comment_created_at, comment.updated_at AS comment_updated_at, comment.comment, comment.user_id AS comment_user_id,
               	user.username AS comment_user_username, user.lastname AS comment_user_lastname, user.firstname AS comment_user_firstname, 'Hidden' AS comment_user_password, user.email AS comment_user_email, user.role AS comment_user_role, user.created_at AS comment_user_created_at, user.updated_at AS comment_user_updated_at,
               	post.admin_id AS admin_id,
               	admin.username AS admin_username, admin.lastname AS admin_lastname, admin.firstname AS admin_firstname, 'Hidden' AS admin_password, admin.email AS admin_email, admin.role AS admin_role, admin.created_at AS admin_created_at, admin.updated_at AS admin_updated_at,
               	portfolio.catch_phrase AS admin_catch_phrase, portfolio.avatar_url AS admin_avatar_url, portfolio.avatar_alt_url AS admin_avatar_alt_url, portfolio.url_cv AS admin_url_cv
               FROM post
               LEFT JOIN comment ON comment.post_id = post.id AND comment.status = 1
               LEFT JOIN user ON comment.user_id = user.id
               LEFT JOIN user as admin ON post.admin_id = admin.id
               LEFT JOIN admin AS portfolio ON portfolio.id_user = admin.id
               WHERE post.slug = '".$slug."'";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $this->transformToPostAndComments($results);
   }

   public function transformToPostAndComments(array $results) {
      $comments = [];
      $post = new Post($results[0]);
      $post->setAdmin(self::createAdmin($results[0]));
      foreach ($results as $element) {
         $user = self::createUser($element);
         if (!is_null($element['comment'])) {
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
         'updated_at' => $element['comment_user_updated_at']
      ];
      return new User($userData);
   }

   public function createAdmin($element) {
      $adminData = [
         'id' => $element['admin_id'],
         'username' => $element['admin_username'],
         'lastname' => $element['admin_lastname'],
         'firstname' => $element['admin_firstname'],
         'password' => $element['admin_password'],
         'email' => $element['admin_email'],
         'role' => $element['admin_role'],
         'created_at' => $element['admin_created_at'],
         'updated_at' => $element['admin_updated_at'],
         'catch_phrase' => $element['admin_catch_phrase'],
         'avatar_url' => $element['admin_avatar_url'],
         'avatar_alt_url' => $element['admin_avatar_alt_url'],
         'url_cv' => $element['admin_url_cv']
      ];
      return new Admin($adminData);
   }


}