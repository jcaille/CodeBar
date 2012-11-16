<?php
class Code {

	public $id; //main key
	public $barTableId; //id of the table the code is linked to
	public $url; //access code ?code=url
	public $active; //boolean set to true if the code is active

	public function __construct($id, $barTableId, $url, $active){
			$this->id = $id;
			$this->barTableId = $barTableId ;
			$this->url = $url;
			$this->active = $active;
	}
	
	public  function get($id){
		$dbh = Database::connect();
		$query = "SELECT * FROM code WHERE id=? LIMIT 1";
		
		$sth = $dbh->prepare($query);
		$sth->execute(array($id));
		
		if ($sth->rowCount() != 1) {
			return null;
		}
		$array = $sth->fetch();
		return new Code($array["id"], $array["barTableId"], $array["url"], $array["active"]);
	}
	
	public  function setToActive(){
		$dbh = Database::connect();
		$query = "UPDATE code SET active=1 WHERE id=? ";
		$sth = $dbh->prepare($query);
		$sth->execute(array($this->id));
	}
	
	public  function setToInactive(){
		$dbh = Database::connect();
		$query = "UPDATE code SET active=0 WHERE id=? ";
		$sth = $dbh->prepare($query);
		$sth->execute(array($this->id));
	}
	
	//Relations with tables
	
	public  function associateWithTable($tableId){
		$dbh = Database::connect();
		$query = "UPDATE code WHERE id=? SET barTableId=?";
		$sth = $dbh->prepare($query);
		$sth->execute(array($this->id, $tableId));
	}
	
	public  function clearAssociation(){
		$this.associateWithTable(-1);
	}
	
	public  function getAssociatedTable(){
		return barTable::get($this->id) ;
	}
}

function matchWithTable($url){
	$dbh = Database::connect();
	$query = "SELECT * FROM code WHERE url=? LIMIT 1";
	$sth = $dbh->prepare($query);
	$sth->execute(array(htmlspecialchars($url)));
	
	if ($sth->rowCount() != 1) {
		return -1;
	} else {
		$a = $sth->fetch();
		if($a["active"] == 1){
			return $a["barTableId"];
		} else {
			return -1;
		}
	}
}
?>