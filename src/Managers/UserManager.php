<?php
namespace App\Managers;

use App\Core\Manager;
use App\Models\User;
use PDO;

class UserManager extends Manager {

   public function tryLogin() {
      $password = $_POST['password'];
      $query = ($this->db)->prepare("SELECT * FROM user WHERE user.email = :email");
      $query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if (!empty($result)) {
         if ($password==$result['password']) {
            self::createSession($result);
            return true;
         } else {
            return false;
         }
      } else {
         return null;
      }
   }

   public function createSession(Array $userElements) {
      $_SESSION['user'] = new User($userElements);
      $_SESSION['loginDate'] = date('Y-m-d H:i:s');
   }


}