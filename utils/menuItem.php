<?php

class MenuItem{
	public $id ;
	public $categoryId ;
	public $name ;
	public $price ;
	public $available ;
	public $pictureFile ;
	public $description ;
	
	public function __construct($id, $categoryId, $name, $price, $available, $pictureFile, $description) {
	    $this->id = $id;
	    $this->categoryId = $categoryId;
	    $this->name = $name;
	    $this->price = $price;
	    $this->available = $available;
	    $this->pictureFile = $pictureFile;
	    $this->description = $description;
	    }
	
	public function get($id){
		$dbh = Database::connect();
		$query = "SELECT * FROM menuItem WHERE id=? LIMIT 1";
		$sth = $dbh->prepare($query);
		$sth->execute(array($id));
		$a = $sth->fetch();
		return new MenuItem($a['id'],$a['categoryId'],$a['name'],$a['price'],$a['available'],$a['pictureFile'], $a['description']);
	}
}

function getAllMenuItems(){
	$dbh = Database::connect();
	$query = "SELECT id FROM menuItem";
	$sth = $dbh->prepare($query);
	$sth->execute();
	
	for($i=0 ; $i<$sth->rowCount() ; $i++){
		$res[$i] = $sth->fetch();
		$res[$i] = MenuItem::get($res[$i]["id"]);
	}
	return $res;
}

?>