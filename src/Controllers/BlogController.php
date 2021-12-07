<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;


class BlogController extends Controller {
   protected PostManager $postManager;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->postManager = new PostManager();
   }

   public function showPost() {
      $slug = $this->params['slug'];
      $post = $this->postManager->findPostAndComments(
         $slug
      );
      $this->render("@client/pages/post.html.twig", [
         'post' => $post
      ]);
   }

   public function showBlog() {
      $pagination['per_page'] = 3;
      $pagination['page_count'] = ceil(($this->postManager->countElements())/$pagination['per_page']);
      $limit = $pagination['per_page'];
      $pagination['current'] = $this->params['page'];
      $offset = ($this->params['page']) * $pagination['per_page'] - $pagination['per_page'];
      $posts = $this->postManager->findBy(
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