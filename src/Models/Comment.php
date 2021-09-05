<?php
namespace App\Models;

use App\Core\Entity;
use App\Managers\UserManager;


class Comment extends Entity {
   private $_user;
   private $_userId;
   private $_postId;
   private $_comment;
   private $_status;

   public function getComment() {
      return $this->_comment;
   }

   public function setComment($value) {
      $this->_comment = $value;
   }

   public function getStatus() {
      return $this->_status;
   }

   public function setStatus($value) {
      $this->_status = $value;
   }

   public function getPostId() {
      return $this->_postId;
   }

   public function setPostId($value) {
      $this->_postId = $value;
   }

   public function getUser() {
      return $this->_user;
   }

   public function setUser($value) {
      $this->_user = $value;
   }

   public function getUserId() {
      return $this->_userId;
   }

   public function setUserId($value) {
      $this->_userId = $value;
      // 1 comment = 1 request (wrong) :
      // $userManager = new UserManager();
      // $this->setUser($userManager->findOneBy([
      //    'id' => $this->_userId
      // ]));
   }

}
