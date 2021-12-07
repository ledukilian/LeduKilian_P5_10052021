<?php
namespace App\Core\Validation;

use App\Core\Validation\ValidatorConstraint;
use App\Services\MessageHandler;

class Validator {
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
      'file' => ' doit comporter un fichier',
      'size' => ' dépasse la taille limite autorisée',
      'type' => ' ne fait pas partie des formats autorisés',
      'compare' => ' ne correspond pas'
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
      'urlCv' => 'CV',
      'avatarUrl' => 'image de profil',
      'avatarAltUrl' => 'texte image de profil',
      'comment' => 'commentaire'
   ];

   public function __construct(Array $data, $manager = null) {
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
      return $this->isValid();
   }

   public function checkLogin() {
      $this->basicValidation()
           ->email('email');
      return $this->isValid();
   }

   public function checkSocial() {
      $this->basicValidation()
           ->containsAlphabet('name')
           ->length('name', 2, 48)
           ->containsAlphabet('icon')
           ->length('icon', 2, 48)
           ->containsAlphabet('link')
           ->length('link', 2, 256)
           ->link('link');
      return $this->isValid();
   }

   public function checkComment() {
      $this->basicValidation()
           ->containsAlphabet('comment')
           ->length('comment', 2, 512);
      return $this->isValid();
   }

   public function checkCV() {
      $this->validator->file('urlCv')
                      ->size('urlCv', 1000000)
                      ->type('urlCv', [
                        'application/pdf' => 'pdf'
                      ]);
      return $this->isValid();
   }

   public function checkProfileImg() {
      $this->validator->file('avatarUrl')
                      ->size('avatarUrl', 2000000)
                      ->type('avatarUrl', [
                        'image/png' => 'png',
                        'image/jpeg' => 'jpg'
                      ])
                      ->minLength('avatarAltUrl', 3);
      return $this->isValid();
   }

   public function checkPost() {
      if (key_exists('coverImg', $_FILES) && !empty($_FILES['coverImg']) && $_FILES['coverImg']['error']==0) {
         $this->validator->file('coverImg')
         ->size('coverImg', 2000000)
         ->type('coverImg', [
           'image/png' => 'png',
           'image/jpeg' => 'jpg'
        ]);
     }
      $this->basicValidation()
           ->containsAlphabet('title')
           ->length('title', 2, 512)
           ->containsAlphabet('lead')
           ->length('lead', 2, 512)
           ->containsAlphabet('coverAltImg')
           ->length('coverAltImg', 2, 512)
           ->containsAlphabet('content')
           ->length('content', 2, 512)
           ->minLength('coverAltImg', 3);
      return $this->isValid();
   }

   public function checkInformations() {
      if (key_exists('password', $this->data) && !empty($this->data['password'])) {
         $this->validator->compare('password', 'password-confirm')
                         ->password('password');
      } else {
         unset($_POST['password']);
         unset($_POST['password-confirm']);
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
      return $this->isValid();

   }

   public function getMessages() {
      $messages = [];
      foreach ($this->getErrors() as $key => $value) {
         $messages[$key] = [
            'type' => 'danger',
            'message' => 'Le champ '.self::$fields[$key].self::$errors[$value]
            ];
      }
      return $messages;
   }










}