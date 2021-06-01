<?php
namespace App\Controllers;

use App\Core\Controller;


class BlogController extends Controller {


   public function showPost() {
      $slug = $this->params['slug'];
      echo "Page du post ".$slug;
      // var_dump($slug);
   }

   public function showBlog() {
      echo "Page du blog";
   }


}