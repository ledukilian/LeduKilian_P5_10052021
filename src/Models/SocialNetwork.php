<?php
namespace App\Models;

use App\Core\Entity;


class SocialNetwork extends Entity {
   private $_name;
   private $_icon;
   private $_link;
   // Un attribut qui le relie à son objet (admin) ?

   public function __construct() {
      parent::__construct();
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