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

   public function findAll() {
      $sql = 'SELECT * FROM '.$this->tableName;
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $this->transformToEntities($results);
   }

   public function findBy(array $where = null, array $order = null, int $limit = null, int $offset = null) {
      $sql = 'SELECT * FROM '.$this->tableName;
      if (sizeof($where)>0) {
         $sql = $this->setWhere($where, $sql);
      }
      if (sizeof($order)>0) {
         $sql = $this->setOrderBy($order, $sql);
      }
      if ($limit>0) {
         $sql = $this->setLimit($limit, $sql);
      }
      if ($offset>0) {
         $sql = $this->setOffset($offset, $sql);
      }
      var_dump($sql);
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $results;
      //return $this->transformToEntities($results);
   }

   public function findOneBy(array $where = null) {
      return $this->findBy($where, null, 1, null);
   }

   public function setWhere(array $where, string $sql) {
      return $sql;
   }

   public function setOrderBy(array $orders, string $sql) {
      $sql .= ' ORDER BY';
      $i = 0;
      for ($i = 0; $i <= sizeof($orders)-1; $i++) {
         $sql .= ' '.$orders[$i]['name'].' '.$orders[$i]['order'].',';
      }
      return substr($sql, 0, -1);
   }

   public function setLimit(int $limit, string $sql) {
      return $sql .= ' LIMIT '.$limit;
   }

   public function setOffset(int $offset, string $sql) {
      return $sql .= ' OFFSET '.$offset;
   }

   public function transformToEntities(array $results) {
      $entities = [];
      foreach ($results as $result) {
         $entities[] = new $this->entity($result);
      }
      return $entities;
   }

















}