<?php
	require_once("loader.php");
	
	if (isset($_GET['todo']) && $_GET['todo'] != '') {
		$todo = $_GET['todo'];
	
	if($todo == "sendCommand"){
		$content = isset($_POST["content"]) ? $_POST["content"] : null ; 
		$tableId = isset($_POST["tableId"]) ? $_POST["tableId"] : null ;
		$command = createNewCommand($tableId, $content);
		//$commandArray = $command->getItemArray();
		if($command == null){
			echo "false" ;
		} else {
			echo "true" ;
		}
	}
	
	if($todo == "getNewCommands"){
		$a = getNewCommands();
		echo(json_encode($a));
	}
	
	if($todo == "getAllCommands"){
		$a = getAllCommands();
		echo(json_encode($a));
	}

	if($todo == "validateCommand"){
		$id = isset($_GET["commandId"]) ? $_GET["commandId"] : -1 ;
		if($id > 0){
			$myCommand = Command::get($id) ;
			echo print_r($myCommand) ;
			$myCommand->setFulfilled() ;
		}

	}

	if($todo == "getInitialData"){
		//TODO : set cookie or something to ID user ?
		$categories = getAllCategories();

		//Load table
		$url = isset($_POST["url"]) ? $_POST["url"] : null ;
		$barTableId = matchWithTable($url) ;

		//Load database
		$itemList = array() ;
		$categoryList = array() ;

		foreach($categories as $cat){
			$categoryItemList = array() ;
			$items = $cat->getMenuItems();
			foreach($items as $item){
				array_push($categoryItemList, $item->id);
				$itemList[$item->id] = $item ;
			}
			array_push($categoryList, array("category" => $cat, "items" => $categoryItemList));
		}
		
		echo json_encode(array("table" => $barTableId, "database" => array("items" => $itemList, "categories" => $categoryList)));
	}

	}
?>