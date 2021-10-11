<?php
namespace App\Core;

use App\Core\PDOFactory;
use ReflectionClass;
use PDO;
use PDOStatement;

class Manager {
   protected $db;
   protected $tableName;
   protected $entity;

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

   public function findBy(array $where = [], array $order = [], int $limit = null, int $offset = null) {
      $sql = 'SELECT * FROM '.$this->tableName;
      if (!empty($where)) {
         $sql = $this->setWhere($where, $sql);
      }
      if (!empty($order)) {
         $sql = $this->setOrderBy($order, $sql);
      }
      if ($limit>0) {
         $sql = $this->setLimit($limit, $sql);
      }
      if ($offset>0) {
         $sql = $this->setOffset($offset, $sql);
      }
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      // var_dump($results);
      return $this->transformToEntities($results);
   }

   public function countElements() {
      $sql = 'SELECT count(*) AS count FROM '.$this->tableName;
      $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      return $results[0]['count'];
   }

   public function findOneBy(array $where = [], array $order = [], int $offset = null) {
      return $this->findBy($where, $order, 1, $offset)[0];
   }

   public function setWhere(array $where, string $sql) {
      $whereSql = '';
      foreach($where as $key => $value) {
            $whereSql .= $key.' = "'.$value.'" AND ';
      }
      if (!empty($whereSql)) {
         return $sql.' WHERE '.substr($whereSql, 0, -5);
      }
      return $sql;
   }

   public function setOrderBy(array $orders, string $sql) {
      $order = '';
      foreach($orders as $key => $value) {
         if (in_array($value, ['ASC', 'DESC'])) {
            $order .= $key.' '.$value.', ';
         }
      }
      if (!empty($order)) {
         return $sql.' ORDER BY '.substr($order, 0, -2);
      }
      return $sql;
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

   public function insert(Entity $object) {
      $properties = implode(', ', $object->getProperties());
      $values = $object->getValues();
      $placeholder = $this->addPlaceholders($values);
      $query = $this->db->prepare('INSERT INTO '.$this->tableName.' ('.$properties.') VALUES ('.$placeholder.');');
      $query = $this->bindValues($query, $values);
      if ($query->execute()) {
         return true;
      } else {
         return false;
      }
   }

   protected function bindValues(PDOStatement $query, array $values) {
        $i = 0;
        foreach ($values as $value) {
            ++$i;
            $query->bindValue($i, $value, \is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        return $query;
    }

   private function addPlaceholders(array $values) {
        $valuesPlaceholder = [];
        $totalValues = \count($values);
        for ($i = 0; $i < $totalValues; ++$i) {
            $valuesPlaceholder[] = '?';
        }
        return implode(', ', $valuesPlaceholder);
    }


}