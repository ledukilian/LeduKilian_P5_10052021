<?php
namespace App\Services;

class MessageHandler {

   public function setMessage($type, $message) {
      $_SESSION['message']['show'] = true;
      if (in_array($type, ['success', 'warning', 'danger', 'primary'])) {
         $_SESSION['message']['type'] = $type;
      } else {
         $_SESSION['message']['type'] = 'primary';
      }
      $_SESSION['message']['text'] = $message;
      return true;
   }




}