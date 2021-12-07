<?php
namespace App\Services;

class FileHandler {
   protected Array $file;
   protected String $filePath;
   protected String $fileType;
   protected String $fileExtension;
   protected Array $allowedTypes;

   public function __construct(String $key) {
      $this->allowedTypes = [
         'application/pdf' => 'pdf',
         'image/png' => 'png',
         'image/jpeg' => 'jpg'
      ];
      if (isset($_FILES[$key])) {
         $this->file = $_FILES[$key];
         $this->fileName = $_FILES[$key]['name'];
         $this->filePath = $_FILES[$key]['tmp_name'];
         $this->fileType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->filePath);
         $this->fileExtension = $this->allowedTypes[$this->fileType];
      }
   }

   public function uploadCV() {
      return $this->upload(PDF_DIR . "/CV.pdf");
   }

   public function uploadProfileImg() {
      return $this->upload(IMG_DIR . "/" . $this->fileName . "." . $this->fileExtension);
   }

   public function uploadPostImg(String $slug) {
      $this->upload(IMG_DIR . "/articles/" . $slug . "." . $this->fileExtension);
      return $slug . "." . $this->fileExtension;
   }

   public function upload(String $toPath) {
      if (!copy($this->filePath, $toPath)) {
         return false;
      }
      $this->delete($this->filePath);
      unlink($this->filePath);
      return true;
   }

   public function delete() {
      unlink($this->filePath);
      return true;
   }












}