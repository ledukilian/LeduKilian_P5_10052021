<?php
namespace App\Core;

use ReflectionClass;
use ReflectionProperty;

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

   public function getReflectionClass() {
      return (new ReflectionClass($this));
   }

   public function getProperties() {
      $properties = [];
      $attr = $this->getReflectionClass()->getProperties();
      foreach ($attr as $attribute) {
         if (($attribute->name)[0]=="_") {
            $properties[] = ltrim($this->camelCaseToSnakeCase($attribute->name), '_');
         }
      }
      return $properties;
   }

   public function getValues() {
      $properties = $this->getProperties();
      $values = [];
      foreach ($properties as $property) {
         $method = 'get'.ucfirst($this->snakeCaseToCamelCase($property));
         if (method_exists($this, $method)) {
            $values[] = $this->{$method}();
         }
      }
      return $values;
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

   public function setUpdatedAt($value) {
      $this->_updatedAt = $value;
   }

   private function camelCaseToSnakeCase(string $property) {
      return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $property));
   }

   private function snakeCaseToCamelCase(string $property) {
      return str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
   }
}