<?php
namespace App\Models;

use App\Core\Entity;


class Post extends Entity {
   private $_title;
   private $_coverImg;
   private $_coverAltImg;
   private $_lead;
   private $_content;
   private $_slug;
   private $_author;

   public function __construct() {
      parent::__construct();
   }

   public function getTitle() {
      return $this->_title;
   }

   public function setTitle($value) {
      $this->_title = $value;
   }

   public function getCoverImg() {
      return $this->_coverImg;
   }

   public function setCoverImg($value) {
      $this->_coverImg = $value;
   }

   public function getCoverAltImg() {
      return $this->_coverAltImg;
   }

   public function setCoverAltImg($value) {
      $this->_coverAltImg = $value;
   }

   public function getLead() {
      return $this->_lead;
   }

   public function setLead($value) {
      $this->_lead = $value;
   }

   public function getContent() {
      return $this->_content;
   }

   public function setContent($value) {
      $this->_content = $value;
   }

   public function getSlug() {
      return $this->_slug;
   }

   public function setSlug($value) {
      $this->_slug = $value;
   }

   public function getSlug() {
      return $this->_slug;
   }

   public function setSlug($value) {
      $this->_slug = $value;
   }

   public function getAuthor() {
      return $this->_author;
   }

   public function setAuthor($value) {
      $this->_author = $value;
   }

}
