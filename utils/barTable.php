<?php
class BarTable {

	public $id; //main key
	public $name; // Name of the table : table 17
	public $shortName; //short name : 17

	public function __construct($id, $name, $shortName){
		$this->id = $id;
		$this->name = $name ;
		$this->shortName = $shortName ;	
	}
	
	public function get($id) {
		$dbh = Database::connect();
		$query = "SELECT * FROM barTable WHERE id=? LIMIT 1";
		$sth = $dbh->prepare($query);
		$sth->execute(array($id));
		if ($sth->rowCount() != 1) {
			return null;
		}
		$a = $sth->fetch();
		return new BarTable($a['id'], $a['name'], $a["shortName"]);
	}
}

function checkTable($url){
	$dbh = Database::connect();
	$query = "SELECT id FROM barTable WHERE url=? LIMIT 1";
	$sth = $dbh->prepare(htmlspecialchars($url));
	$sth->execute(array($id));
	if ($sth->rowCount() != 1) {
		return -1;
	} else {
		$a = $sth->fetch();
		return $a["id"];
	}
}
?>