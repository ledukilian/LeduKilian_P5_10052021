<?php
namespace App\Core;

use PDO;
use PDOException;
use App\Exceptions\ConfigException;

class PDOFactory {
   private $pdo;
   private $config;

   public function __construct()  {
      $this->config = $this->getConfig();
      $this->pdo = $this->getMySQLConnection();
   }

   private function getConfig() {
      if (file_exists(CONF_DIR."/db-config.yml")) {
         return yaml_parse_file(CONF_DIR."/db-config.yml");
      } else {
         throw new ConfigException('<i class="fas fa-exclamation-circle text-danger mx-2"></i>Erreur avec la configuration de la base de données :<br /><span class="text-warning">Le fichier de configuration n\'existe pas</span>');
      }
   }

   public function getMySQLConnection() {
      try {
         $pdo = new PDO('mysql:host='.$this->config['host'].';dbname='.$this->config['name'].";charset=utf8mb4;",$this->config['user'],$this->config['pass']);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $pdo;
     }
     catch(PDOException $error){
        throw new PDOException('<i class="fas fa-exclamation-circle text-danger mx-2"></i>Erreur avec la base de données :<br /><span class="text-warning">' . $error->getMessage().'</span>');
     }


   }













}