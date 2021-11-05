<?php



class Validator {
   private ValidatorConstraint $validator;
   protected Array $data;

   public function __construct(Array $data, $manager = null) {
      $this->data = $data;
      $this->validator = new ValidatorConstraint($this->data, $manager);
   }

   // Validation de base, fonction basicValidation
   // 1 fonction par formulaire

   public function basicValidation() {
      // Fonction de validation de base
   }

   public function checkAdminForm() {
      // Si mot de passe vide : on l'enlève du post
   }

}