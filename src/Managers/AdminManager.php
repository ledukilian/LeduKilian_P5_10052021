<?php
namespace App\Managers;

use App\Core\Manager;

class AdminManager extends Manager {

   public function findAdminBy(array $where = []) {
         $sql = 'SELECT * FROM '.$this->tableName.' JOIN user ON admin.id_user = user.id';
         if (!empty($where)) {
            $sql = $this->setWhere($where, $sql);
         }
         $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
         // var_dump($results);
         return $this->transformToEntities($results);
   }



}