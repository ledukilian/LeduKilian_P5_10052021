<?php
namespace App\Services;

class FileHandler {
   protected String $defaultPath;
   protected String $defaultName;
   protected Float $maxSize;
   protected String $formats;
   protected String $fileName
   protected Array $file;
   protected Array $field;

   public function __construct(String $field) {
      if (isset($_FILES[$field])) {
         $this->file = $_FILES[$field];
         $this->defaultPath = '/public/img/articles/';
         $this->defaultName = 'article.png';
         $this->maxSize = 2000000;
      }
   }


   public function copyToDir() {
      copy("___file___", $espacePhoto."Par_defaut.png");
   }


   public function c

if (!is_dir($espacePhoto)) {
    mkdir($espacePhoto, 0777);
};

if (isset($_FILES['photo']) && $_FILES['photo']['error']<=0) {
    /* On "explose" le nom de l'image */
    $nomPhotoExploded = explode(".", $_FILES['photo']['name']);
    /* On récupère l'extension du logo */
    $extensionLogo = strtolower(end($nomPhotoExploded));
    /* On déplace l'image dans le répertoire correspondant */
    move_uploaded_file($_FILES['photo']["tmp_name"], $espacePhoto.$_POST['nomphoto']);
    // echo '<br /><br /><h1>Là ça a russie</h1><br /><br />';
}