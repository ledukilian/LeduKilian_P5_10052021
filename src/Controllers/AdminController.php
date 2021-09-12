<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Managers\SocialManager;


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
      $commentManager = new CommentManager();
      $comments = $commentManager->getCommentsAndInfos();
      $this->render("@admin/pages/blog/comments.html.twig", [
         'comments' => $comments
      ]);
   }

   public function editPortfolio() {
      $this->render("@admin/pages/portfolio/edit.html.twig", []);
   }

   public function editSocials() {
      $socialManager = new SocialManager();
      $socials = $socialManager->findBy(
         [
            'id_admin' => 1
         ]
      );
      $this->render("@admin/pages/portfolio/editSocials.html.twig", [
         'socials' => $socials
      ]);
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

   public function showError() {
      $this->render("@admin/errors/error.html.twig", []);
   }

   public function show404() {
      $this->render("@admin/errors/404.html.twig", []);
   }


}










