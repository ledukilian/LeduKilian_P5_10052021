<?php
namespace App\Core;

class DB {


   public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = '', $charset = 'utf8') {
		$this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($this->connection->connect_error) {
			$this->error('Echec de la connexion MySQL - ' . $this->connection->connect_error);
		}
		$this->connection->set_charset($charset);
	}

   public function fetchAll(string $table) {
      $sql = 'SELECT * FROM '.$table.';'

      return
   }
}