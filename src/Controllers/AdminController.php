<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\CommentManager;


class AdminController extends Controller {
   public function showAdmin() {
      $postManager = new PostManager();
      $commentManager = new CommentManager();
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         10
      );
      $this->render("@admin/pages/index.html.twig", [
         'posts' => $posts,
         'articles_count' => $postManager->countElements(),
         'comments_count' => $commentManager->countElements()
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
      $postManager = new PostManager();
      $posts = $postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         10
      );
      $this->render("@admin/pages/blog/list.html.twig", [
         'posts' => $posts
      ]);
   }

   public function addPost() {
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function editPost() {
      $slug = $this->params['slug'];
      $postManager = new PostManager();
      $post = $postManager->findBy(
         [
            'id' => $slug
         ],
         [
            'created_at' => 'DESC'
         ]
      );
      $this->render("@admin/pages/blog/edit.html.twig", [
         'post' => $post[0]
      ]);
   }

   public function deletePost() {
      echo "Page de suppression d'un post";
   }


}










