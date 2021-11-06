<?php
namespace App\Core\Validation;


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
      if (!key_exists($key, $this->data)) {
         $this->addError($key, 'required');
      }
      return $this;
   }

   public function allRequired() {
      foreach ($this->data as $key => $value) {
         $this->required($key);
      }
      return $this;
   }

   public function notEmpty($key) {
      if (empty($this->data[$key]) || $this->data[$key]===null) {
         $this->addError($key, 'not_empty');
      }
      return $this;
   }

   public function allNotEmpty() {
      foreach ($this->data as $key => $value) {
         $this->notEmpty($key);
      }
      return $this;
   }

   public function email($key) {
      if (!filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)) {
         $this->addError($key, 'email');
      }
      return $this;
   }

   public function password($key) {
      return $this->length($key, 6, 256)
                  ->containsNumber($key)
                  ->containsAlphabet($key);
   }

   public function containsAlphabet($key) {
      if (!preg_match('~[a-zA-Z]+~', $this->data[$key])) {
         $this->addError($key, 'alphabet');
      }
      return $this;
   }

   public function containsNumber($key) {
      if (!preg_match('~[0-9]+~', $this->data[$key])) {
         $this->addError($key, 'number');
      }
      return $this;
   }

   public function slug($key) {
      // À faire
      // $this->addError($key, 'slug');
   }

   public function unique($key) {
      // À faire
      // $this->addError($key, 'unique');
      return $this;
   }

   public function length($key, $min, $max) {
      return $this;
      return $this->minLength($key, $min)
                  ->maxLength($key, $max);
   }

   public function minLength($key, $min) {
      // À faire
      // $this->addError($key, 'min_length');
      return $this;
   }

   public function maxLength($key, $max) {
      // À faire
      // $this->addError($key, 'max_length');
      return $this;
   }

   public function addError(String $key, String $error) {
      $this->errors[$key] = $error;
   }

   public function getErrors() {
      return $this->errors;
   }


}