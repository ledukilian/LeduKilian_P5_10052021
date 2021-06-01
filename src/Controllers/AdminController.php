<?php
namespace App\Controllers;

use App\Core\Controller;


class AdminController extends Controller {


   public function addPost() {
      echo "Page d'ajout d'un post";
   }

   public function editPost() {
      echo "Page de modification d'un post";
   }

   public function deletePost() {
      echo "Page de suppression d'un post";
   }


}