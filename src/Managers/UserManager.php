<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\User;
use PDO;

class UserManager extends Manager {

   public function tryLogin() {
      $password = $_POST['password'];
      $user = $this->findOneBy(
         [
            'email' => $_POST['email']
         ],
      );
      if (!empty($user)) {
         if (password_verify($password, $user->getPassword())) {
            $user->setPassword('Hidden');
            self::createSession($user);
            return $user;
         } else {
            return 'Le mot de passe ne correspond pas à l\'adresse mail associée';
         }
      } else {
         return 'Le compte avec l\'adresse mail suivante n\'existe pas';
      }
   }

   public function createSession(User $userElements) {
      $_SESSION['user'] = $userElements;
      $_SESSION['loginDate'] = date('Y-m-d H:i:s');
      $_SESSION['logged'] = TRUE;
   }

   public function checkUserInformations() {
      // Empty
   }
















}