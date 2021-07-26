<?php
namespace App\Managers;

use App\Core\Manager;
use PDO;

class AdminManager extends Manager {

   public function findAdminBy(int $id) {
         $sql = 'SELECT * FROM admin JOIN user ON admin.id_user = user.id WHERE admin.id = '.$id;

         $results = ($this->db)->query($sql)->fetchAll(PDO::FETCH_ASSOC);
         $entities = $this->transformToEntities($results);
         if (empty($entities)) {
            return null;
         }
         return $entities[0];
   }



}