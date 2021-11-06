<?php



class ValidatorConstraint {
   protected Array $data;
   protected Array $errors = [];
   protected Manager $manager;

   public function __construct(Array $data, $manager = null) {
      $this->data = $data;
      if ($manager) {
         $this->manager = $manager;
      }
   }

   public function required($key) {
      if (key_exists($key, $this->data)) {
         $this->addError($key, 'required');
      }
      return $this;
   }

   public function allRequired($keys) {
      foreach ($keys as $key) {
         $this->required($key);
      }
      return $this;
   }

   public function notEmpty($key) {
      if (empty($this->data[$key]) || $this->data[$key]==null) {
         $this->addError($key, 'not_empty');
      }
      return $this;
   }

   public function allNotEmpty($keys) {
      foreach ($keys as $key) {
         $this->notEmpty($key);
      }
      return $this;
   }

   public function unique($key) {
      // À faire
   }

   public function length($key, $min, $max) {
      // À faire
   }

   public function email($key) {
      // À faire
   }

   public function password($key) {
      // À faire

   }

   public function slug($key) {
      // À faire
   }

   public function addError(String $key, String $error) {
      $this->errors[$key] = $error;
   }

   public function getErrors() {
      return $this->errors;
   }


}