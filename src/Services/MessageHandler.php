<?php
namespace App\Services;

class MessageHandler {
   public function setMessage($type, $text) {
      if (!isset($_SESSION['messages'])) {
         $_SESSION['messages'] = [];
      }
      $message = [];
      if (in_array($type, ['success', 'warning', 'danger', 'primary'])) {
         $message['type'] = $type;
      } else {
         $message['type'] = 'primary';
      }
      $message['text'] = $text;

      array_push($_SESSION['messages'], $message);
      return true;
   }

   public function getMessages() {
      if (!isset($_SESSION['messages'])) {
         return false;
      }
      return $_SESSION['messages'];
   }

   public function cleanMessages() {
      unset($_SESSION['messages']);
   }


}