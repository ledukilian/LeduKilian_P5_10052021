<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Managers\SocialManager;
use App\Managers\AdminManager;
use App\Services\FormHandler;
use App\Models\Post;
use App\Models\Social;


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
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $postManager = new PostManager();
         $post = new Post($_POST);
         $post->setAdminId($_SESSION['user']->getId());
         $post->setSlug($postManager->slugify($_POST['title']));
         $postManager->insert($post);
      }
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function addSocial() {
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $socialManager = new SocialManager();
         $social = new Social($_POST);
         $social->setIdAdmin($_SESSION['user']->getId());
         if ($socialManager->insert($social)) {
            header('Location: /admin/reseaux/');
            exit;
         }
      }
   }

   public function deleteSocial() {
      if (!empty($this->params['id'])) {
         $socialManager = new SocialManager();
         $social = $socialManager->findOneBy(['id' => $this->params['id']]);
         if ($socialManager->delete($social)) {
            header('Location: /admin/reseaux/');
            exit;
         }
      }
   }

   public function editPost() {
      $slug = $this->params['slug'];
      $postManager = new PostManager();
      $post = $postManager->findBy(
         [
            'slug' => $slug
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
      if (!empty($this->params['slug'])) {
         $postManager = new PostManager();
         $post = $postManager->findOneBy(['slug' => $this->params['slug']]);
         if ($postManager->delete($post)) {
            header('Location: /admin/');
            exit;
         }
      }
   }

   public function showError() {
      $this->render("@admin/errors/error.html.twig", []);
   }

   public function show404() {
      $this->render("@admin/errors/404.html.twig", []);
   }


}










