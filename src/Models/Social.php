<?php
namespace App\Models;

use App\Core\Entity;


class Social extends Entity {
   private $_id_admin;
   private $_name;
   private $_icon;
   private $_link;


   public function __construct() {
      parent::__construct();
   }

   public function getIdAdmin() {
      return $this->_id_admin;
   }

   public function setIdAdmin($value) {
      $this->_id_admin = $value;
   }

   public function getName() {
      return $this->_name;
   }

   public function setName($value) {
      $this->_name = $value;
   }

   public function getIcon() {
      return $this->_icon;
   }

   public function setIcon($value) {
      $this->_icon = $value;
   }

   public function getLink() {
      return $this->_link;
   }

   public function setLink($value) {
      $this->_link = $value;
   }

}