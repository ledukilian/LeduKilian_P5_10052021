<?php
namespace App\Services;

class FileHandler {
   private static $max_size;
   private static $formats;
   protected Array $file;

   public function __construct() {
      if (!empty($_FILES)) {
         $this->file = $_FILES[0];
      }
      self::max_size = 200000;
      self::formats = [
         'image/jpeg',
         'image/png'
      ];
   }

public function check() {
      $this->checkFormat()
            ->checkSize()
            ->generateName();

      if () {
         return $path;
      }

}

public function checkSize() {

}