<?php
namespace App\Core\Validation;

use App\Core\Validation\ValidatorConstraint;
use App\Services\MessageHandler;

class Validator {
   protected MessageHandler $messageHandler;
   private ValidatorConstraint $validator;
   protected Array $data;
   public static $TEXTS = [
      'number' => ' doit comporter au moins un caractère numérique'
   ];
   public static $FIELDS = [
      'password' => ' mot de passe '
   ];

   public function __construct(Array $data, $manager = null) {
      $this->messageHandler = new MessageHandler();
      $this->data = $data;
      $this->validator = new ValidatorConstraint($this->data, $manager);
   }

   public function getErrors() {
      return $this->validator->getErrors();
   }

   public function isValid() {
      if (sizeof($this->getErrors())==0) {
         return true;
      } else {
         return false;
      }
   }

   public function basicValidation() {
      return $this->validator->allNotEmpty()
                             ->allRequired();
   }

   public function checkRegister() {
      $this->basicValidation()
           ->email('email')
           ->password('password')
           ->containsAlphabet('lastname')
           ->containsAlphabet('firstname');
      $this->showMessagesFromErrors();
      return $this;
   }

   public function checkLogin() {
      $this->basicValidation()
           ->email('email')
           ->password('password');
      $this->showMessagesFromErrors();
      return $this;
   }

   public function showMessagesFromErrors() {
      foreach ($this->getErrors() as $key => $value) {
         $this->messageHandler->setMessage('danger', 'Le champ '.self::$FIELDS[$key].self::$TEXTS[$value]);
      }
   }






























}