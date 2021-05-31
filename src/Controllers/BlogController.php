<?php
namespace App\Controllers;

use App\Core\Controller;


class BlogController extends Controller {


   public function showPost() {
      $slug = $this->params['id_post'];
      var_dump($slug);
   }

}