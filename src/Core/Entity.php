<?php
namespace App\Core;

class Entity {
   private $_id;
   private $_createdAt;
   private $_updatedAt;

   public function __construct() {
      // Empty constructor
   }

   public function hydrate() {
      // Function hydrate
   }

   public function getId() {
      return $this->_id;
   }

   public function getCreatedAt() {
      return $this->_createdAt;
   }

   public function getUpdatedAt() {
      return $this->_updatedAt;
   }

   public function setId($value) {
      $this->_id = $value;
   }

   public function setCreatedAt($value) {
      $this->_createdAt = $value;
   }

   public function setUpdatedAt() {
      $this->_updatedAt = $value;
   }
}