<?php
class Command{
	public $id ;
	public $barTableId ;
	public $creationTime ;
	public $state ; //Either "posted", "received", "fullfilled", "aborted"
	public $content ; //JSON blob of text
	
	public function __construct($id, $barTableId, $creationTime, $state, $content) {
	    $this->id = $id ;
	    $this->barTableId = $barTableId ;
	    $this->creationTime = $creationTime ;
	    $this->state = $state ;
	    $this->content = $content ;
	}
	
	public function get($id){
		$dbh = Database::connect();
		$query = "SELECT * FROM command WHERE id = ? LIMIT 1";
		$sth = $dbh->prepare($query);
		$sth->execute(array(htmlspecialchars($id)));
		$a = $sth->fetch();
		return new Command($a["id"], $a["barTableId"], $a["creationTime"], $a["state"], $a["content"]);
	}

	public function getPrice(){
		$price = 0 ;
		foreach(json_decode($this->content, true) as $itemId => $quantity){
			$price += MenuItem::get($itemId)->price * $quantity;
		}
		return $price ;
	}

	public function getItemArray(){
		$res = array();
		$i = 0;
		foreach(json_decode($this->content, true) as $itemId => $quantity){
			if($quantity > 0){
				$res[$i] = array(MenuItem::get($itemId), $quantity);
				$i++;
			}
		}
		return $res ;
	}

	public function getArray(){
		$res = array();
		$table = BarTable::get($this->barTableId);
		$res["state"] = $this->state ;
		$res["barTableName"] = $table->name;
		$res["barTableShortName"] = $table->shortName;
		$res["content"] = $this->getItemArray();
		$res["price"] = $this->getPrice();
		$res["creationTime"] = $this->creationTime ;
		return $res;
	}

	public function setReceived(){
		$dbh = Database::connect();
		$query = "UPDATE command SET state='received' WHERE id=? ";
		$sth = $dbh->prepare($query);
		$sth->execute(array($this->id));
		// echo 'received '.$this->id ;
	}
}

function createNewCommand($barTableId, $content){
	$dbh = Database::connect();
	
	//Check if table is valid
	if(barTable::get($barTableId) == null){
		return null ;
	}
	
	$query = "INSERT INTO command (barTableId, creationTime, state, content) VALUES (?, NOW(), 'posted', ?)";
	$sth = $dbh->prepare($query);
	$sth->execute(array(htmlspecialchars($barTableId), htmlspecialchars($content)));
	$id = $dbh->lastInsertId();
	$command = Command::get($id);
	return $command ;
}

function getNewCommands(){
	$dbh = Database::connect();
	$query = "SELECT id FROM command WHERE state='posted' ORDER BY creationTime";
	$sth = $dbh->prepare($query);
	$sth->execute();
	$res = array() ;
	for($i = 0 ; $i < $sth->rowCount() ; $i++){
		$a = $sth->fetch() ;
		$id = $a['id'];
		$command = Command::get($id);
		$command->setReceived();
		$res[$i] = $command->getArray();
	}
	return $res ;
}

function getAllCommands(){
	$dbh = Database::connect();
	$query = "SELECT id FROM command WHERE state <> 'aborted' ORDER BY creationTime";
	$sth = $dbh->prepare($query);
	$sth->execute();
	$res = array() ;
	for($i = 0 ; $i < $sth->rowCount() ; $i++){
		$a = $sth->fetch() ;
		$id = $a['id'];
		$command = Command::get($id);
		$res[$i] = $command->getArray();
	}
	return $res ;
}