<?php
namespace App\Core;

use App\Core\PDOFactory;
use ReflectionClass;
use PDO;

class Manager {
   private $db;
   private $tableName;
   private $entity;

   public function __construct()  {
      $this->db = (new PDOFactory())->getMySQLConnection();
      $this->tableName = $this->getTableName();
      $this->entity = "\\App\\Models\\".ucfirst($this->tableName);
   }

   private function getTableName() {
      $managerName = (new ReflectionClass($this))->getShortName();
      return strtolower(str_replace('Manager', '', $managerName));
   }

   public function test() {
      $test = (new PDOFactory())->getMySQLConnection();
      var_dump($test);

   }

   public function findAll() {
      $sql = 'SELECT * FROM '.$this->tableName;
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $this->transformToEntities($results);
   }

   // TODO : findBy
   // where (tableau : AND et =), order (valeur ASC ou DESC), limit, offset
   // return entities

   // TODO : findOneBy : findBy avec LIMIT 1

   

   public function transformToEntities(array $results) {
      $entities = [];
      foreach ($results as $result) {
         $entities[] = new $this->entity($result);
      }
      return $entities;
   }

















}