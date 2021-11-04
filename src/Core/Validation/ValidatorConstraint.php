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

   }

   public function notEmpty($key) {

   }

   public function unique($key) {

   }

   public function length($key, $min, $max) {

   }

   public function email($key) {

   }

   public function password($key) {

   }

   public function slug($key) {

   }







}