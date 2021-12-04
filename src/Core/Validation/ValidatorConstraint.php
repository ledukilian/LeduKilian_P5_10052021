<?php
namespace App\Core\Validation;


class ValidatorConstraint {
   protected Array $data;
   protected Array $errors = [];
   protected $manager;

   public function __construct(Array $data, $manager = null) {
      $this->data = $data;
      if ($manager) {
         $this->manager = $manager;
      }
   }

   public function updateData(Array $data) {
      $this->data = $data;
   }

   public function required(String $key) {
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

   public function notEmpty(String $key) {
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

   public function email(String $key) {
      if (!filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)) {
         $this->addError($key, 'email');
      }
      return $this;
   }

   public function password(String $key) {
      return $this->length($key, 6, 256)
                  ->containsNumber($key)
                  ->containsAlphabet($key);
   }

   public function containsAlphabet(String $key) {
      if (!preg_match('~[a-zA-Z]+~', $this->data[$key])) {
         $this->addError($key, 'alphabet');
      }
      return $this;
   }

   public function containsNumber(String $key) {
      if (!preg_match('~[0-9]+~', $this->data[$key])) {
         $this->addError($key, 'number');
      }
      return $this;
   }

   public function minLength(String $key, $min) {
      if (strlen($this->data[$key])<$min) {
         $this->addError($key, 'min_length');
      }
      return $this;
   }

   public function maxLength(String $key, $max) {
      if (strlen($this->data[$key])>$max) {
         $this->addError($key, 'max_length');
      }
      return $this;
   }

   public function slug(String $key) {
      if(!preg_match('/^[a-z][-a-z0-9]*$/', $this->data[$key])){
         $this->addError($key, 'slug');
      }
      return $this;
   }

   public function link(String $key) {
      if (filter_var($this->data[$key], FILTER_VALIDATE_URL) === FALSE) {
         $this->addError($key, 'link');
      }
      return $this;
   }

   public function unique(String $key) {
      $already_exist = $this->manager->findOneBy([
         $key => $this->data[$key]
      ]);
      if ($already_exist) {
         $this->addError($key, 'unique');
      }
      return $this;
   }

   public function file(String $key) {
      if (!key_exists($key, $_FILES)) {
         $this->addError($key, 'file');
      }
      return $this;
   }

   public function size(String $key, Int $max_weight) {
      if ($_FILES[$key]['size'] > $max_weight) {
         $this->addError($key, 'size');
      }
      $fileSize = filesize($_FILES[$key]['tmp_name']);
      if ($fileSize > $max_weight) {
         $this->addError($key, 'size');
      }
      return $this;
   }

   public function type(String $key, Array $formats) {
      $fileInfos = finfo_open(FILEINFO_MIME_TYPE);
      $fileType = finfo_file($fileInfos, $_FILES[$key]['tmp_name']);
      if (!in_array($fileType, array_keys($formats))) {
         $this->addError($key, 'type');
      }
      return $this;
   }

   public function compare(String $key1, String $key2) {
      if ($this->data[$key1]!=$this->data[$key2]) {
         $this->addError($key1, 'compare');
      }
      return $this;
   }

   public function length(String $key, Int $min, Int $max) {
      return $this->minLength($key, $min)
                  ->maxLength($key, $max);
   }

   public function addError(String $key, String $error) {
      $this->errors[$key] = $error;
   }

   public function getErrors() {
      return $this->errors;
   }


}