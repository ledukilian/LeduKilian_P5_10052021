<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Managers\CommentManager;
use App\Managers\SocialManager;
use App\Managers\AdminManager;
use App\Managers\UserManager;
use App\Services\TwigGlobals;
use App\Services\MessageHandler;
use App\Services\FileHandler;
use App\Core\Validation\Validator;
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
   protected Validator $validator;
   protected FileHandler $fileHandler;

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
         3
      );
      $this->render("@admin/pages/index.html.twig", [
         'posts' => $posts,
         'users_count' => $this->userManager->countElements(),
         'articles_count' => $this->postManager->countElements(),
         'comments_count' => $this->commentManager->countElements(),
         'messages' => $this->messageHandler->getMessages()
      ]);
   }

   public function showCommentList() {
      $this->redirectIfNotAdmin();
      $comments = $this->commentManager->getCommentsAndInfos();
      $this->render("@admin/pages/blog/comments.html.twig", [
         'comments' => $comments,
         'messages' => $this->messageHandler->getMessages()
      ]);
   }

   public function showEditInformations() {
      $this->redirectIfNotAdmin();
      $this->messageHandler->addMessages($this->validator->getMessages());
      $this->render("@admin/pages/informations/edit.html.twig", [
         'messages' => $this->messageHandler->getMessages()
      ]);

   }

   public function editInformations() {
      if (!empty($_POST)) {
         $this->validator = new Validator($_POST, $this->userManager);
         if ($this->validator->checkInformations()) {
            $admin = $this->adminManager->findOneBy([
               'id' => $this->twigGlobals->getAdminId()
            ]);
            $user = $this->userManager->findOneBy([
               'id' => $this->twigGlobals->getAdminId()
            ]);
            $user->hydrate($_POST);
            $admin->hydrate($_POST);
            if (key_exists('password', $_POST) && !empty($_POST['password'])) {
               $user->setPasswordHashed($user->getPassword());
            }
            if ($this->adminManager->update($admin) && $this->userManager->update($user)) {
               $this->messageHandler->addMessage('success', 'Les informations ont bien été mise à jour');
               $this->redirectToAdmin();
            } else {
               $this->messageHandler->addMessage('danger', 'Une erreur est survenue lors de la mise à jour des informations');
            }
         }
      }
      $this->showEditInformations();
   }

   public function editCV() {
      if ($this->validator->checkCV()) {
         $this->fileHandler = new FileHandler('urlCv');
         if ($this->fileHandler->uploadCV()) {
            $this->messageHandler->addMessage('success', 'Le CV a bien été mis à jour');
         } else {
            $this->messageHandler->addMessage('danger', 'Une erreur est survenue lors de la mise à jour du CV');
         }
      }
      $this->showEditInformations();
   }

   public function editProfileImg() {
      if ($this->validator->checkProfileImg()) {
         $this->fileHandler = new FileHandler('avatarUrl');

         $admin = $this->adminManager->findOneBy([
            'id' => $this->twigGlobals->getAdminId()
         ]);
         $admin->hydrate($_POST);
         $admin->setAvatarUrl('/img/'.$_FILES['avatarUrl']['name']);
         if ($this->fileHandler->uploadProfileImg() && $this->adminManager->update($admin)) {
            $this->messageHandler->addMessage('success', 'La photo de profil a bien été mis à jour');
         } else {
            $this->messageHandler->addMessage('danger', 'Une erreur est survenue lors de la mise à jour de la photo de profil');
         }
      }
      $this->showEditInformations();
   }

   public function showSocialList() {
      $this->redirectIfNotAdmin();
      $socials = $this->socialManager->findBy(
         [
            'id_admin' => 1
         ]
      );
      $this->messageHandler->addMessages($this->validator->getMessages());
      $this->render("@admin/pages/informations/socialList.html.twig", [
         'socials' => $socials,
         'messages' => $this->messageHandler->getMessages()
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

   public function showPostForm() {
      $this->redirectIfNotAdmin();
      $this->messageHandler->addMessages($this->validator->getMessages());
      $this->render("@admin/pages/blog/add.html.twig", [
         'messages' => $this->messageHandler->getMessages()
      ]);

   }

   public function addPost() {
      if (!empty($_POST)) {
         $this->validator = new Validator($_POST, $this->postManager);
         if ($this->validator->checkPost()) {
            $this->fileHandler = new FileHandler('coverImg');
            $post = new Post($_POST);
            $post->setAdminId($_SESSION['user']->getId());
            $post->setSlug($this->postManager->slugify($_POST['title']));
            $post->setCoverImg($this->fileHandler->uploadPostImg($post->getSlug()));
            if ($this->postManager->insert($post)) {
               $this->messageHandler->addMessage('success', 'Le nouveau post a bien été ajouté');
               $this->redirectToAdmin();
            } else {
               $this->messageHandler->addMessage('danger', 'Une erreur est survenue lors de l\'ajout du post');
            }
         }
         $this->redirectToSelf();
      }
      $this->showPostForm();
   }

   public function addSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $this->validator->checkSocial();
         if ($this->validator->checkSocial()) {
            $social = new Social($_POST);
            $social->setIdAdmin($_SESSION['user']->getId());
            if ($this->socialManager->insert($social)) {
               $this->messageHandler->addMessage('success', 'Le nouveau réseau social a bien été ajouté');
            } else {
               $this->messageHandler->addMessage('danger', 'Une erreur est survenue lors de l\'ajout du réseau social');
            }
         }
         $this->showSocialList();
      }
   }

   public function editSocial() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         if ((new Validator($_POST))->checkSocial()) {
            $social = $this->socialManager->findOneBy([
               'id' => $this->params['id']
            ]);
            $social->hydrate($_POST);
            if ($this->socialManager->update($social)) {
               $this->messageHandler->setMessage('success', 'Le réseau social a bien été mis à jour');
            } else {
               $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la mise à jour du réseau social');
            }
         }
         $this->redirectToSocial();
      }
   }

   public function showPostEdit() {
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

   public function editPost() {
      $this->redirectIfNotAdmin();
      if (!empty($_POST)) {
         $this->validator = new Validator($_POST, $this->postManager);
         if ($this->validator->checkPost()) {
            $post = $this->postManager->findOneBy([
               'slug' => $this->params['slug']
            ]);
            $post->hydrate($_POST);
            if (isset($_FILES['coverImg']) && $_FILES['coverImg']['error']==0) {
               $this->fileHandler = new FileHandler('coverImg');
               $post->setSlug($this->postManager->slugify($_POST['title']));
               $post->setCoverImg($this->fileHandler->uploadPostImg($post->getSlug()));
            }
            if ($this->postManager->update($post)) {
               $this->messageHandler->setMessage('success', 'Le post a bien été modifié');
            } else {
               $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la modification du post');
            }
            $this->redirectToAdmin();
         }
      }
   }




   public function deleteSocial() {
      $this->redirectIfNotAdmin();
      $social = $this->socialManager->findOneBy(['id' => $this->params['id']]);
      if ($this->deleteElement($this->socialManager, $social, $this->params['id'])) {
         $this->messageHandler->setMessage('success', 'Le réseau social a bien été supprimé');
         $this->redirectToSocial();
      } else {
         $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du réseau social');
      }
   }

   public function deletePost() {
      $this->redirectIfNotAdmin();
      $post = $this->postManager->findOneBy(['slug' => $this->params['slug']]);
      if ($this->deleteElement($this->postManager, $post, $this->params['slug'])) {
         $this->messageHandler->setMessage('success', 'Le post de blog a bien été supprimé');
         $this->redirectToAdmin();
      } else {
         $this->messageHandler->setMessage('danger', 'Une erreur est survenue lors de la suppression du post');
      }
   }

   public function deleteElement($manager, $element, $param) {
      if (!empty($param)) {
         return $manager->delete($element);
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










