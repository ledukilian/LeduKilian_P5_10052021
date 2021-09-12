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
      $this->render("@client/pages/post.html.twig", [
         'post' => $post
      ]);
   }

   public function showBlog() {
      $pagination['per_page'] = 6;
      $postManager = new PostManager();
      $pagination['page_count'] = ceil(($postManager->countElements())/$pagination['per_page']);
      $limit = $pagination['per_page'];
      $pagination['current'] = $this->params['page'];
      $offset = ($this->params['page']) * $pagination['per_page'] - $pagination['per_page'];
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         $limit,
         $offset
      );
      $this->render("@client/pages/blog.html.twig", [
         'posts' => $posts,
         'pagination' => $pagination
      ]);
   }

}