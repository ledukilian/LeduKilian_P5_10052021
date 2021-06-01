<?php
namespace App\Models;

use App\Core\Entity;


class Comment extends Entity {
   private $_content;
   private $_status;

   public function __construct() {
      parent::__construct();
   }

   public function getContent() {
      return $this->_content;
   }

   public function setContent($value) {
      $this->_content = $value;
   }

   public function getStatus() {
      return $this->_status;
   }

   public function setContent($value) {
      $this->_status = $value;
   }

}
