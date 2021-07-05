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
      $PDOFactory = new PDOFactory();
      $this->db = $PDOFactory->getPDO();
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

   public function findAll(int $limit = null) {
      $sql = 'SELECT * FROM '.$this->tableName;
      if (is_numeric($limit)) {
         $sql .= ' LIMIT '.$limit;
      }
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $results;
   }




















}