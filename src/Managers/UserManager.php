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
         if (password_verify($password, $result['password'])) {
         //if ($password==$result['password']) {
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

















}