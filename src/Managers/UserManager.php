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
         var_dump($password);
         var_dump($user->getPassword());
         var_dump(password_verify($password, $user->getPassword()));
         if (password_verify($password, $user->getPassword())) {
            $user->setPassword('Hidden');
            self::createSession($user);
            return true;
         } else {
            return false;
         }
      } else {
         return null;
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