<?php
namespace App\Core;

class Entity {
   private $_id;
   private $_createdAt;
   private $_updatedAt;

   public function __construct(array $data = []) {
      if (!empty($data)) {
         $this->hydrate($data);
      }
   }

   public function hydrate(array $data)
   {
      foreach ($data as $attribut => $value) {
           $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
           if (is_callable(array($this, $method))) {
               $this->$method($value);
           }
      }
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