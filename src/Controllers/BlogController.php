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
         //'post' => $post[0],
         'post' => $post
      ]);
   }

   public function showBlog() {
      $postManager = new PostManager();
      $pagination = $postManager->getPagination();
      $limit = $pagination['per_page'];
      if (isset($this->params['slug'])) {
         $offset = ($this->params['slug']) * $pagination['per_page'] - $pagination['per_page'];
         $pagination['current'] = $this->params['slug'];
      } else {
         $offset = 0;
         $pagination['current'] = 1;
      }
      // var_dump($limit);
      // var_dump($offset);
      // die;
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