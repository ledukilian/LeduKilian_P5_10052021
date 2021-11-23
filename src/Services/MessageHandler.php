<?php
namespace App\Services;

class MessageHandler {
   private Array $messages;

   public function __construct() {
      $this->messages = [];
   }

   public function getMessages() {
      return $this->messages;
   }

   public function setMessages(Array $value) {
      $this->messages = $value;
   }

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

   public function addMessages(Array $messages) {
      foreach ($messages as $message) {
         $this->addMessage($message['type'], $message['text'], $message['field']);
      }
   }

   public function addMessage(String $type, String $text, String $field = 'global') {
         array_push($this->messages, [
            'type' => $type,
            'field' => $field,
            'text' => $text
         ]);
         return true;
   }

   public function resetMessages() {
      unset($_SESSION['messages']);
   }


}