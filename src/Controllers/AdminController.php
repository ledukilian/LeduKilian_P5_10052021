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
   protected MessageHandler $messageHandler;
   protected TwigGlobals $twigGlobals;
   protected UserManager $userManager;
   protected AdminManager $adminManager;
   protected PostManager $postManager;
   protected CommentManager $commentManager;
   protected SocialManager $socialManager;

   public function __construct($action, $params = NULL) {
      parent::__construct($action, $params);
      $this->messageHandler = new MessageHandler();
      $this->twigGlobals = new TwigGlobals();
      $this->userManager = new UserManager();
      $this->adminManager = new AdminManager();
      $this->postManager = new PostManager();
      $this->commentManager = new CommentManager();
      $this->socialManager = new SocialManager();
   }

   public function showAdmin() {
      $this->redirectIfNotAdmin();
      $posts = $this->postManager->findBy(
         [],
         [
            'created_at' => 'DESC'
         ],
         10
      );
      $this->render("@admin/pages/index.html.twig", [
         'posts' => $posts,
         'articles_count' => $this->postManager->countElements(),
         'comments_count' => $this->commentManager->countElements()
      ]);
   }

   public function showCommentList() {
      $this->redirectIfNotAdmin();
      $comments = $this->commentManager->getCommentsAndInfos();
      $this->render("@admin/pages/blog/comments.html.twig", [
         'comments' => $comments
      ]);
   }

   public function editInformations() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         if (empty(trim($_POST['password']))) {
            unset($_POST['password']);
         }
         $admin = $this->hydrateAdminFromPost($_POST);
         $user = $this->hydrateUserFromPost($_POST);
         if ($this->adminManager->update($admin) && $this->userManager->update($user)) {
            $this->messageHandler->setMessage('success', 'Les informations ont bien été mise à jour');
            $this->redirectToAdmin();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la mise à jour des informations');
         }
      }
      $this->render("@admin/pages/informations/edit.html.twig", []);
   }

   public function hydrateUserFromPost($data) {
      $user = $this->userManager->findOneBy([
         'id' => $this->twigGlobals->getAdminId()
      ]);
      $user->hydrate($_POST);
      $user->setPasswordHashed($user->getPassword());
      return $user;
   }

   public function hydrateAdminFromPost($data) {
      $admin = $this->adminManager->findOneBy([
         'id' => $this->twigGlobals->getAdminId()
      ]);
      $admin->hydrate($_POST);
      return $admin;
   }

   public function showSocialList() {
      $this->redirectIfNotAdmin();
      $socials = $this->socialManager->findBy(
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
      $posts = $this->postManager->findBy(
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
         $post = new Post($_POST);
         $post->setAdminId($_SESSION['user']->getId());
         $post->setSlug($this->postManager->slugify($_POST['title']));
         if ($this->postManager->insert($post)) {
            $this->messageHandler->setMessage('success', 'Le nouveau post a bien été ajouté');
            $this->redirectToAdmin();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'ajout du post');
         }
      }
      $this->render("@admin/pages/blog/add.html.twig", []);
   }

   public function addSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST) && (new FormHandler())->checkform($_POST)) {
         $social = new Social($_POST);
         $social->setIdAdmin($_SESSION['user']->getId());
         if ($this->socialManager->insert($social)) {
            $this->messageHandler->setMessage('success', 'Le nouveau réseau social a bien été ajouté');
            $this->redirectToSocial();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de l\'ajout du réseau social');
         }
      }
   }

   public function editSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $social = $this->socialManager->findOneBy([
            'id' => $this->params['id']
         ]);
         $social->hydrate($_POST);
         if ($this->socialManager->update($social)) {
            $this->messageHandler->setMessage('success', 'Le réseau social a bien été mis à jour');
            $this->redirectToSocial();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la mise à jour du réseau social');
         }
      }
   }

   public function editPost() {
      $this->redirectIfNotAdmin();
      $slug = $this->params['slug'];
      $post = $this->postManager->findBy(
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
         $social = $this->socialManager->findOneBy(['id' => $this->params['id']]);
         if ($this->socialManager->delete($social)) {
            $this->messageHandler->setMessage('success', 'Le réseau social a bien été supprimé');
            $this->redirectToSocial();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du réseau social');
         }
      }
   }

   public function deletePost() {
      $this->redirectIfNotAdmin();
      if (!empty($this->params['slug'])) {
         $post = $this->postManager->findOneBy(['slug' => $this->params['slug']]);
         if ($this->postManager->delete($post)) {
            $this->messageHandler->setMessage('success', 'Le post de blog a bien été supprimé');
            $this->redirectToAdmin();
         } else {
            $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du post');
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










