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

		//Create html response string
		$htmlString = "" ;
		$htmlString = $htmlString . '<div class="row-fluid"><div id="categoryAccordion">';
		foreach($categories as $cat){
			$items = $cat->getMenuItems() ;
			$htmlString = $htmlString . '<div class="accordion-group" id="category'.$cat->id.'">';
			$htmlString = $htmlString . '<div class="accordion-heading">';
			$htmlString = $htmlString . '<a class="accordion-toggle" data-toggle="collapse" data-parent="#categoryAccordion" href="#collapse'.$cat->id.'">';
			$htmlString = $htmlString . "<div class='row-fluid'><h4 class='span10'>".$cat->name."</h4>" ;
			$htmlString = $htmlString . '<span id="badgeCategory'.$cat->id.'" class="badgeCategory badge badge-success pull-right">0</span></div>';
			$htmlString = $htmlString . '</a></div><div id="collapse'.$cat->id.'" class="accordion-body collapse in">';
			$htmlString = $htmlString . '<div class="accordion-inner">';
			for($i = 0 ; $i < count($items) ; $i++){
				$item = $items[$i];
				$htmlString = $htmlString . "<div class='container-fluid item' id='item".$item->id."'>" ;

				$htmlString = $htmlString . "<div class='span2'>" ;
				$htmlString = $htmlString . '<span id="badgeItem'.$item->id.'" class="badgeItem badge badge-success">0</span>';
				$htmlString = $htmlString . '<span class="removeItemBadge badge badge-important"  id="removeItem'.$item->id.'">-</span>';
				$htmlString = $htmlString . '<span class="removeItemButton" id="removeItemButton'.$item->id.'"></span>' ;
				$htmlString = $htmlString . "</div>" ;

				$htmlString = $htmlString . "<div class='span7'>" ;
				$htmlString = $htmlString . '<h3>'.$item->name .'</h3>';
				$htmlString = $htmlString . '<p><strong>'.$item->price.'€ </strong>';
				if($item->description != null){
					$htmlString  = $htmlString . ' - ' . $item->description ;
				}
				$htmlString = $htmlString .'</p>';
				$htmlString = $htmlString . "</div>" ;

				$htmlString = $htmlString . "<div class='span3'>" ;
				$htmlString = $htmlString . '<img src="http://placehold.it/300x300" />';
				$htmlString = $htmlString . "</div>" ;

				$htmlString = $htmlString . '</div>' ;
				if( $i != count($items) -1 ){
					$htmlString = $htmlString . "<hr/>" ;
				}
			}
			$htmlString = $htmlString . '</div></div></div>';
			
		}
		$htmlString = $htmlString . '</div></div>';

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
		
		echo json_encode(array("table" => $barTableId, "database" => array("items" => $itemList, "categories" => $categoryList), "htmlContent" => $htmlString));
	}

	}
?>