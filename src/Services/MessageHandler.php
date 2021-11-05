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

   public function getMessage() {
      if (!isset($_SESSION['message'])) {
         $_SESSION['message']['show'] = false;
      }
      return $_SESSION['message'];
   }

   public function cleanMessage() {
      return $_SESSION['message']['show'] = false;
   }


}