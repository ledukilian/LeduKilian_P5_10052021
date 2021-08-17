<?php
namespace App\Managers;

use App\Core\Manager;
use PDO;

class PostManager extends Manager {

   // TODO : findPostWithCommentsAndAuthors
   public function findPostAndComments(String $slug) {
      $sql = "SELECT post.id AS post_id
               , user_b.firstname AS post_firstname
               , user_b.lastname AS post_lastname
               , user_b.username AS post_username
               , post.title
               , post.cover_img
               , post.cover_alt_img
               , post.lead
               , post.content
               , post.slug
               , comment.content AS com_content
               , comment.created_at AS com_date
               , user_a.firstname AS com_firstname
               , user_a.lastname AS com_lastname
               , user_a.username AS com_username
               FROM post
               JOIN comment ON post.id = comment.id_post
               JOIN user AS user_a ON comment.id_user = user_a.id
               JOIN admin ON post.id_admin = admin.id
               JOIN user AS user_b ON admin.id_user = user_b.id
               WHERE post.slug = 'slug'
               AND comment.status = 1";
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      $entities = $this->transformToEntities($results);
      return $results;
   }





}