<?php
namespace App\Models;

use App\Core\Entity;


class User extends Entity {
   private $_username;
   private $_lastname;
   private $_firstname;
   private $_email;
   private $_password;
   private $_role;

   public function getUsername() {
      return $this->_username;
   }

   public function setUsername($value) {
      $this->_username = $value;
   }

   public function getLastname() {
      return $this->_lastname;
   }

   public function setLastname($value) {
      $this->_lastname = $value;
   }

   public function getFirstname() {
      return $this->_firstname;
   }

   public function setFirstname($value) {
      $this->_firstname = $value;
   }

   public function getEmail() {
      return $this->_email;
   }

   public function setEmail($value) {
      $this->_email = $value;
   }

   public function getPassword() {
      return $this->_password;
   }

   public function setPasswordHashed($value) {
      $this->_password = password_hash($value, PASSWORD_DEFAULT);
   }

   public function setPassword($value) {
      if (!empty(trim($value))) {
         $this->_password = $value;
      }
   }

   public function getRole() {
      return $this->_role;
   }

   public function setRole($value) {
      $this->_role = $value;
   }

   public function isAdmin() {
      return ($this->_role)=='ADMIN';
   }

}