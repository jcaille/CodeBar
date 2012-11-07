<?php

class Category{
	public $id;
	public $name;
	
	public function __construct($id, $name){
		$this->id = $id ;
		$this->name = $name ;
	}
	
	public function get($id){
		$dbh = Database::connect();
		$query = "SELECT * FROM category WHERE id=? LIMIT 1";
		$sth = $dbh->prepare($query);
		$sth->execute(array($id));
		
		$a = $sth->fetch();
		return new Category($a["id"], $a["name"]);
	}
	
	public function getMenuItems(){
		$dbh = Database::connect();
		$query = "SELECT id FROM menuItem WHERE categoryId=? ";
		$sth = $dbh->prepare($query);
		$sth->execute(array($this->id));
		$res = array();
		
		for($i=0 ; $i<$sth->rowCount() ; $i++){
			$res[$i] = $sth->fetch();
			$res[$i] = MenuItem::get($res[$i]["id"]);
		}
		return $res;
	}
}

function getAllCategories(){
	$dbh = Database::connect();
	$query = "SELECT id FROM category";
	$sth = $dbh->prepare($query);
	$sth->execute();
	
	for($i=0 ; $i<$sth->rowCount() ; $i++){
		$res[$i] = $sth->fetch();
		$res[$i] = Category::get($res[$i]["id"]);
	}
	return $res;
}

?>