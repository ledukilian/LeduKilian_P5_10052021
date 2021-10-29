<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Managers\SocialManager;
use App\Managers\AdminManager;
use App\Managers\UserManager;
use App\Services\FormHandler;
use App\Services\TwigGlobals;
use App\Models\Post;
use App\Models\Social;
use App\Models\Admin;
use App\Models\User;


class AdminController extends Controller {
   public function showAdmin() {
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
      $commentManager = new CommentManager();
      $comments = $commentManager->getCommentsAndInfos();
      $this->render("@admin/pages/blog/comments.html.twig", [
         'comments' => $comments
      ]);
   }

   public function editPortfolio() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $twigGlobals = new TwigGlobals();
         $userManager = new UserManager();
         $adminManager = new AdminManager();
         $admin = new Admin($_POST);
         $user = new User($_POST);
         $admin->setId($twigGlobals->getAdminId());
         $user->setId($twigGlobals->getAdminId());
         if ($adminManager->update($admin) && $userManager->update($user)) {
            return true;
         } else {
            return false;
         }
      }
      $this->render("@admin/pages/portfolio/edit.html.twig", []);
   }

   public function editSocials() {
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
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
      $this->redirectIfNotAdmin();
      $this->render("@admin/errors/error.html.twig", []);
   }

   public function show404() {
      $this->redirectIfNotAdmin();
      $this->render("@admin/errors/404.html.twig", []);
   }


}










