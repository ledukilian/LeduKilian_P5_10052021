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

   // public function required($key) {
   //    // À faire
   // }
   //
   // public function notEmpty($key) {
   //    // À faire
   // }
   //
   // public function unique($key) {
   //    // À faire
   // }
   //
   // public function length($key, $min, $max) {
   //    // À faire
   // }
   //
   // public function email($key) {
   //    // À faire
   // }
   //
   // public function password($key) {
   //    // À faire
   //
   // }
   //
   // public function slug($key) {
   //    // À faire
   // }







}