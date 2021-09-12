<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\UserManager;
use App\Managers\PostManager;


class AccountController extends Controller {


   public function login() {
      if (isset($_POST['email'])) {
         $userManager = new UserManager();
         if ($userManager->tryLogin()) {
            $postManager = new PostManager();
            $posts = $postManager->findBy(
               [],
               [
                  'created_at' => 'DESC'
               ],
               3
            );
            $this->render("@client/pages/index.html.twig", [
               'posts' => $posts
            ]);
         }
      } else {
         $this->render("@client/pages/login.html.twig", []);
      }
}

   public function register() {
      $this->render("@client/pages/register.html.twig", []);
   }


}