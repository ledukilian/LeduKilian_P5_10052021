<?php
namespace App\Models;

use App\Core\Entity;


class User extends Entity {
   private $_username;
   private $_lastName;
   private $_firstName;
   private $_email;
   private $_password;
   private $_role;

   public function __construct() {
      parent::__construct();
   }

   public function getRole() {
      return $this->_role;
   }

   public function setRole($value) {
      $this->_role = $value;
   }

   public function getPassword() {
      return $this->_password;
   }

   public function setPassword($value) {
      $this->_password = $value;
   }

   public function getEmail() {
      return $this->_email;
   }

   public function setEmail($value) {
      $this->_email = $value;
   }

   public function getFirstName() {
      return $this->_firstName;
   }

   public function setFirstName($value) {
      $this->_firstName = $value;
   }

   public function getLastName() {
      return $this->_lastName;
   }

   public function setLastName($value) {
      $this->_lastName = $value;
   }

   public function getUsername() {
      return $this->_username;
   }

   public function setUsername($value) {
      $this->_username = $value;
   }



}