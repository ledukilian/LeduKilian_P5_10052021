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
      'max_length' => ' comporte trop de caractères',
      'compare' => ' ne correspondent pas entre eux'
   ];
   public static $fields = [
      'email' => 'adresse mail',
      'username' => 'nom d\'utilisateur',
      'firstname' => 'prénom',
      'lastname' => 'nom',
      'password' => 'mot de passe',
      'password-confirm' => 'confirmation de mot de passe',
      'name' => 'nom',
      'subject' => 'sujet',
      'message' => 'message',
      'title' => 'titre de l\'article',
      'content' => 'contenu de l\'article',
      'coverAltImg' => 'texte de l\'image de l\'article',
      'lead' => 'phrase d\'accroche',
      'icon' => 'icône',
      'link' => 'lien',
      'comment' => 'commentaire'
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
      $this->setMessagesFromErrors();
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
      $this->setMessagesFromErrors();
      return $this->isValid();
   }

   public function checkLogin() {
      $this->basicValidation();
      $this->setMessagesFromErrors();
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
      $this->setMessagesFromErrors();
      return $this->isValid();
   }

   public function checkComment() {
      $this->basicValidation()
           ->containsAlphabet('comment')
           ->length('comment', 2, 512);
      $this->setMessagesFromErrors();
      return $this->isValid();
   }

   public function checkPost() {
      $this->basicValidation()
           ->containsAlphabet('title')
           ->length('title', 2, 512)
           ->containsAlphabet('lead')
           ->length('lead', 2, 512)
           ->containsAlphabet('coverAltImg')
           ->length('coverAltImg', 2, 512)
           ->containsAlphabet('content')
           ->length('content', 2, 512);
      $this->setMessagesFromErrors();
      return $this->isValid();
   }

   public function checkInformations() {
      if (key_exists('password', $this->data) && !empty($this->data['password'])) {
         $this->password('password')
              ->password('password-confirm')
              ->compare('password', 'password-confirm');
      } else {
         unset($this->data['password']);
         unset($this->data['password-confirm']);
         $this->validator->updateData($this->data);
      }
      $this->basicValidation()
           ->containsAlphabet('catchPhrase')
           ->length('catchPhrase', 2, 512)
           ->email('email')
           ->containsAlphabet('lastname')
           ->length('lastname', 2, 48)
           ->containsAlphabet('firstname')
           ->length('firstname', 2, 48)
           ->containsAlphabet('username')
           ->length('username', 2, 48);
      $this->showMessagesFromErrors();
      return $this->isValid();

   }

   public function getMessages() {
      return $this->messageHandler->getMessages();
   }

   public function setMessagesFromErrors() {
      $messages = [];
      foreach ($this->getErrors() as $key => $value) {
         $messages[$key] = 'Le champ '.self::$fields[$key].self::$errors[$value];
      }
      $this->messageHandler->setMessages($messages);
      return true;
   }

   public function showMessagesFromErrors() {
      foreach ($this->getErrors() as $key => $value) {
         $this->messageHandler->setMessage('danger', 'Le champ '.self::$fields[$key].self::$errors[$value]);
      }
   }






























}