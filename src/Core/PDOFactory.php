<?php
namespace App\Core;

use PDO;
use PDOException;

class PDOFactory {
   private $pdo;
   private $config;

   public function __construct()  {
      $this->config = $this->getConfig();
      $this->pdo = $this->getMySQLConnection();
   }

   private function getConfig() {
      return yaml_parse_file(CONF_DIR."/db-config.yml");
   }

   public function getMySQLConnection() {
      try {
         $pdo = new PDO('mysql:host='.$this->config['host'].';dbname='.$this->config['name'].";charset=utf8mb4;",$this->config['user'],$this->config['pass']);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $pdo;
     }
     catch(PDOException $ex){
        throw new PDOException('Erreur avec la base de données : ' . $ex->getMessage());
     }
      // echo 'test';
      // var_dump($this->$db);


   }













}