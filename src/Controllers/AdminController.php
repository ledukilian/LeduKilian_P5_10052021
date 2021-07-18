<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;


class AdminController extends Controller {
   public function showAdmin() {
      $postManager = new PostManager();
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         10
      );

      $this->render("@admin/pages/index.html.twig", [
         'posts' => $posts
      ]);

   }

   public function showCommentList() {
      $this->render("@admin/pages/blog/comments.html.twig", []);
   }

   public function editPortfolio() {
      $this->render("@admin/pages/portfolio/edit.html.twig", []);
   }

   public function editSocialNetworks() {
      $this->render("@admin/pages/portfolio/editSocialNetworks.html.twig", []);
   }

   public function showPostList() {
      $this->render("@admin/pages/blog/list.html.twig", []);
   }

   public function addPost() {
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function editPost() {
      $post = 12;
      $this->render("@admin/pages/blog/edit.html.twig", [
         'post' => $post
      ]);
   }

   public function deletePost() {
      echo "Page de suppression d'un post";
   }


}