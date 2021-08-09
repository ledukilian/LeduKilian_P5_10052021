<?php
namespace App\Models;

use App\Models\User;


class Admin extends User {
   private $_avatarUrl;
   private $_avatarAltUrl;
   private $_catchPhrase;
   private $_urlCV;

   public function getParent() {
      // 🔴 TODO : Récupération du parent (User) ?
   }

   public function getAvatarUrl() {
      return $this->_avatarUrl;
   }

   public function setAvatarUrl($value) {
      $this->_avatarUrl = $value;
   }

   public function getAvatarAltUrl() {
      return $this->_avatarAltUrl;
   }

   public function setAvatarAltUrl($value) {
      $this->_avatarAltUrl = $value;
   }

   public function getCatchPhrase() {
      return $this->_catchPhrase;
   }

   public function setCatchPhrase($value) {
      $this->_catchPhrase = $value;
   }

   public function getUrlCV() {
      return $this->_urlCV;
   }

   public function setUrlCV($value) {
      $this->_urlCV = $value;
   }



}