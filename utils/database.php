<?php

$DBH = null;

class Database {

	public static function connect() {
		/* a modifier avant de mettre en ligne */
		global $DBH;

		$dsn = 'mysql:dbname=codebar;host=localhost';
		$user = 'root';
		$password = 'Nutella';

		if ($DBH == null){
			try {
				$dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo 'Connexion échouée : ' . $e->getMessage();
				exit(0);
			}

			$DBH = $dbh;
			return $dbh;
		} else {
			return $DBH;
		}
	}
}

?>