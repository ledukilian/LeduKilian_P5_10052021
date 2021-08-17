<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;


class BlogController extends Controller {
   public function showPost() {
      $slug = $this->params['slug'];
      $postManager = new PostManager();
      $post = $postManager->findPostAndComments(
         $slug
      );
      var_dump($post[0]);
      $this->render("@client/pages/post.html.twig", [
         //'post' => $post[0],
         'post' => $post
      ]);
   }

   public function showBlog() {
      $postManager = new PostManager();
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         9
      );
      $this->render("@client/pages/blog.html.twig", [
         'posts' => $posts
      ]);
   }

}