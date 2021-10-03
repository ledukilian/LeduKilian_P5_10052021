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
            return true;
         } else {
            return false;
         }
      } else {
         return null;
      }
   }

   public function createSession(Array $userElements) {
      $_SESSION['user'] = $userElements;
      $_SESSION['loginDate'] = date('Y-m-d H:i:s');
      $_SESSION['logged'] = TRUE;
   }

   public function createUser() {
      $_POST['username'] = htmlspecialchars($_POST['username']);
      $_POST['email'] = htmlspecialchars($_POST['email']);
      $_POST['firstname'] = htmlspecialchars($_POST['firstname']);
      $_POST['lastname'] = htmlspecialchars($_POST['lastname']);
      $query = ($this->db)->prepare("INSERT INTO user
         VALUES (DEFAULT, :username, :lastname, :firstname, :email, :password, 'USER', NOW(), NOW())");
      $query->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
      $query->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
      $query->bindParam(':firstname', $_POST['firstname'], PDO::PARAM_STR);
      $query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
      $query->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
      return $query->execute();
   }

   public function checkUserInformations() {
      // Empty
   }
















}