<?php
namespace App\Services;

class FormHandler {




   public function checkForm($arrayData) {
      foreach ($arrayData as $data) {
         if (empty($data)) {
            return false;
         }
      }
      return true;
   }





}