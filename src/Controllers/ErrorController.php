<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Managers\PostManager;
use App\Core\PDOFactory;

class ErrorController {

   public function __construct() {

   }

   public function showCriticalError($params) {
      if (isset($params['message'])) {
         $error = $params['message'];
      } else {
         $error = 'Erreur inconnue';
      }
      include("../templates/admin/errors/critical.php");
   }



}