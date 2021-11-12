<?php
namespace App\Core\Validation;

use App\Core\Validation\ValidatorConstraint;
use App\Services\MessageHandler;

class Validator {
   protected MessageHandler $messageHandler;
   private ValidatorConstraint $validator;
   protected Array $data;
   public static $errors = [
      'alphabet' => ' doit comporter des lettres',
      'number' => ' doit comporter au moins un caractère numérique',
      'not_empty' => ' ne doit pas être vide',
      'required' => ' est requis',
      'email' => ' doit correspondre à un format d\'email valide',
      'slug' => ' n\'est pas un format de slug valide',
      'unique' => ' existe déjà',
      'link' => ' n\'est pas un format de lien valide',
      'min_length' => ' ne contient pas assez de caractères',
      'max_length' => ' comporte trop de caractères'
   ];
   public static $fields = [
      'email' => ' adresse mail ',
      'username' => ' nom d\'utilisateur ',
      'firstname' => ' prénom ',
      'lastname' => ' nom ',
      'password' => ' mot de passe ',
      'password-confirm' => ' confirmation de mot de passe ',
      'name' => ' nom ',
      'subject' => ' sujet ',
      'message' => ' message ',
      'icon' => ' icône ',
      'link' => ' lien ',
      'comment' => ' commentaire '
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
      return sizeof($this->getErrors())==0;
   }

   public function basicValidation() {
      return $this->validator->allNotEmpty()
                             ->allRequired();
   }

   public function checkRegister() {
      $this->basicValidation()
           ->email('email')
           ->unique('email')
           ->password('password')
           ->containsAlphabet('lastname')
           ->length('lastname', 2, 48)
           ->containsAlphabet('firstname')
           ->length('firstname', 2, 48)
           ->containsAlphabet('username')
           ->length('username', 2, 48)
           ->unique('username');
      $this->showMessagesFromErrors();
      return $this->isValid();
   }

   public function checkContact() {
      $this->basicValidation()
           ->email('email')
           ->containsAlphabet('name')
           ->length('name', 2, 48)
           ->containsAlphabet('subject')
           ->length('subject', 2, 48)
           ->containsAlphabet('message')
           ->length('message', 2, 512);
      $this->showMessagesFromErrors();
      return $this->isValid();
   }

   public function checkLogin() {
      $this->basicValidation();
      $this->showMessagesFromErrors();
      return $this->isValid();
   }

   public function checkSocial() {
      $this->basicValidation()
           ->containsAlphabet('name')
           ->length('name', 6, 48)
           ->containsAlphabet('icon')
           ->length('icon', 6, 48)
           ->containsAlphabet('link')
           ->length('link', 6, 256)
           ->link('link');
      $this->showMessagesFromErrors();
      return $this->isValid();
   }

   public function checkComment() {
      $this->basicValidation()
           ->containsAlphabet('comment')
           ->length('comment', 2, 512);
      $this->showMessagesFromErrors();
      return $this->isValid();
   }

   public function showMessagesFromErrors() {
      foreach ($this->getErrors() as $key => $value) {
         $this->messageHandler->setMessage('danger', 'Le champ '.self::$fields[$key].self::$errors[$value]);
      }
   }






























}