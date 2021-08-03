<?php
namespace App\Models;

use App\Core\Entity;


class Social extends Entity {
   private $_id_user;
   private $_catch_phrase;
   private $_avatar_url;
   private $_alt_avatar_url;
   private $_url_cv;


   public function __construct() {
      parent::__construct();
   }

   public function getIdUser() {
      return $this->_id_user;
   }

   public function setIdUser($value) {
      $this->_id_user = $value;
   }

   public function getCatchPhrase() {
      return $this->_catch_phrase;
   }

   public function setCatchPhrase($value) {
      $this->_catch_phrase = $value;
   }

   public function getAvatarUrl() {
      return $this->_avatar_url;
   }

   public function setAvatarUrl($value) {
      $this->_avatar_url = $value;
   }

   public function getAltAvatarUrl() {
      return $this->_alt_avatar_url;
   }

   public function setAltAvatarUrl($value) {
      $this->_alt_avatar_url = $value;
   }

   public function getUrlCV() {
      return $this->_url_cv;
   }

   public function setUrlCV($value) {
      $this->_url_cv = $value;
   }

}