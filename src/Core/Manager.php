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

   public function findBy(array $where = null, array $order = null, integer $limit = 0, integer $offset = 0) {
      $sql = 'SELECT * FROM '.$this->tableName;
      if (isset($where)) {
         $sql = $this->setWhere($where, $sql);
      }
      if (isset($order)) {
         $sql = $this->setOrderBy($order, $sql);
      }
      if ($limit>0) {
         $sql = $this->setLimit($limit, $sql);
      }
      if ($offset>0) {
         $sql = $this->setOffset($offset, $sql);
      }
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $this->transformToEntities($results);

   }

   public function setWhere(array $where, string $sql) {

   }

   public function setOrderBy(array $order, string $sql) {
      $sql .= ' ORDER BY ';
      foreach ($order as &$element) {
         $sql .= $element['name'].' '$element['order'].',';
      }
      return substr($sql, 0, -1);
   }

   public function setLimit(integer $limit, string $sql) {
      return $sql .= ' LIMIT '.$limit;
   }

   public function setOffset(integer $offset, string $sql) {
      return $sql .= ' OFFSET '.$offset;
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