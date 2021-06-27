<?php
namespace App\Controllers;

use App\Core\Controller;


class AdminController extends Controller {
   public function showAdmin() {
      $this->render("@admin/pages/index.html.twig", []);
   }

   public function showCommentList() {
      $this->render("@admin/pages/blog/comments.html.twig", []);
   }

   public function editPortfolio() {
      $this->render("@admin/pages/portfolio/edit.html.twig", []);
   }

   public function showPostList() {
      $this->render("@admin/pages/blog/list.html.twig", []);
   }

   public function addPost() {
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function editPost() {
      echo "Page de modification d'un post";
   }

   public function deletePost() {
      echo "Page de suppression d'un post";
   }


}