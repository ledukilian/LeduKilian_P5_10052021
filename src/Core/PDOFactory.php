<?php
namespace App\Core;

use PDO;

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
      $dsn = 'mysql:dbname='.$this->config['name'].';host='.$this->config['host'];
      $pdo = new PDO($dsn, $this->config['user'], $this->config['pass']);
      //$db = new PDO('mysql:host='.$this->config['host'].';dbname='.$this->config['name'],$this->config['user'],$this->config['pass']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo 'test';
      // var_dump($this->$db);
      return $pdo;
   }

   public function getPDO() {
      return $this->pdo;
   }













}