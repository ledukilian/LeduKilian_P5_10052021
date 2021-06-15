<?php
namespace App\Controllers;

use App\Core\Controller;


class BlogController extends Controller {


   public function showPost() {
      $slug = $this->params['slug'];
         $this->render("@client/pages/post.html.twig", [
            'postId' => $slug,
         ]);
      //echo "Page du post ".$slug;
      // var_dump($slug);
   }

   public function showBlog() {
      $this->render("@client/pages/blog.html.twig", []);
   }


}