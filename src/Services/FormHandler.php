<?php
namespace App\Services;

class FormHandler {
   const RULES = [];

   public function __construct() {

   }

   public function checkNotEmpty(Array $formData) {
      foreach ($formData as $data) {
         if (empty($data)) {
            return false;
         }
      }
      return true;
   }



}