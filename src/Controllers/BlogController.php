<?php
namespace App\Controllers;

use App\Core\Controller;


class BlogController extends Controller {


   public function showPost() {
      $slug = $this->params['slug'];
      var_dump($slug);
   }

}