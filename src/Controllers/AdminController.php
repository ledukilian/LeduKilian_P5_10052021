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
use App\Services\MessageHandler;
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

   public function editInformations() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $messageHandler = new MessageHandler();
         $twigGlobals = new TwigGlobals();
         $userManager = new UserManager();
         $adminManager = new AdminManager();
         $admin = $adminManager->findOneBy([
            'id' => $twigGlobals->getAdminId()
         ]);
         $user = $userManager->findOneBy([
            'id' => $twigGlobals->getAdminId()
         ]);
         $user->hydrate($_POST);
         $admin->hydrate($_POST);
         if ($adminManager->update($admin) && $userManager->update($user)) {
            $messageHandler->setMessage('success', 'Les informations ont bien été mise à jour');
            header('Location: /admin/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de la mise à jour des informations');
         }
      }
      $this->render("@admin/pages/informations/edit.html.twig", []);
   }

   public function showSocialList() {
      $this->redirectIfNotAdmin();
      $socialManager = new SocialManager();
      $socials = $socialManager->findBy(
         [
            'id_admin' => 1
         ]
      );
      $this->render("@admin/pages/informations/socialList.html.twig", [
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
         $messageHandler = new MessageHandler();
         $postManager = new PostManager();
         $post = new Post($_POST);
         $post->setAdminId($_SESSION['user']->getId());
         $post->setSlug($postManager->slugify($_POST['title']));
         if ($postManager->insert($post)) {
            $messageHandler->setMessage('success', 'Le nouveau post a bien été ajouté');
            header('Location: /admin/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'ajout du post');
         }
      }
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function addSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $messageHandler = new MessageHandler();
         $socialManager = new SocialManager();
         $social = new Social($_POST);
         $social->setIdAdmin($_SESSION['user']->getId());
         if ($socialManager->insert($social)) {
            $messageHandler->setMessage('success', 'Le nouveau réseau social a bien été ajouté');
            header('Location: /admin/reseaux/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'ajout du réseau social');
         }
      }
   }

   public function editSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $messageHandler = new MessageHandler();
         $socialManager = new SocialManager();
         $social = $socialManager->findOneBy([
            'id' => $this->params['id']
         ]);
         $social->hydrate($_POST);
         if ($socialManager->update($social)) {
            $messageHandler->setMessage('success', 'Le réseau social a bien été mis à jour');
            header('Location: /admin/reseaux/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de la mise à jour du réseau social');
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

   public function deleteSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($this->params['id'])) {
         $socialManager = new SocialManager();
         $messageHandler = new MessageHandler();
         $social = $socialManager->findOneBy(['id' => $this->params['id']]);
         if ($socialManager->delete($social)) {
            $messageHandler->setMessage('success', 'Le réseau social a bien été supprimé');
            header('Location: /admin/reseaux/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du réseau social');
         }
      }
   }

   public function deletePost() {
      $this->redirectIfNotAdmin();
      if (!empty($this->params['slug'])) {
         $messageHandler = new MessageHandler();
         $postManager = new PostManager();
         $post = $postManager->findOneBy(['slug' => $this->params['slug']]);
         if ($postManager->delete($post)) {
            $messageHandler->setMessage('success', 'Le post de blog a bien été supprimé');
            header('Location: /admin/');
            exit;
         } else {
            $messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du post');
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










