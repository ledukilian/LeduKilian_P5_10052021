<?php
namespace App\Controllers;

use App\Core\Controller;


class AdminController extends Controller {
   public function showAdmin() {
      $this->render("@admin/pages/index.html.twig", []);
   }

   public function addPost() {
      $this->render("@admin/pages/blog/ajouter.html.twig", []);
   }

   public function editPost() {
      echo "Page de modification d'un post";
   }

   public function deletePost() {
      echo "Page de suppression d'un post";
   }


}