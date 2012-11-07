<?php
	require_once("loader.php");
	
	if (isset($_GET['todo']) && $_GET['todo'] != '') {
		$todo = $_GET['todo'];
	
	if($todo == "displayCategoriesAccordion"){
		$categories = getAllCategories();
		echo '<div id="categoryAccordion">';
		foreach($categories as $cat){
			$items = $cat->getMenuItems() ;
			echo '<div class="accordion-group" id="category'.$cat->id.'">';
			echo '<div class="accordion-heading">';
			echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#categoryAccordion" href="#collapse'.$cat->id.'">';
			echo "<div class='row-fluid'><h4 class='span10'>".$cat->name."</h4>" ;
			echo '<span id="badgeCategory'.$cat->id.'" class="badgeCategory badge badge-success pull-right">0</span></div>';
			echo '</a></div><div id="collapse'.$cat->id.'" class="accordion-body collapse in">';
			echo '<div class="accordion-inner">';
			for($i = 0 ; $i < count($items) ; $i++){
				$item = $items[$i];
				if($i % 3 == 0){
					echo '<ul class="thumbnails">' ;
				}
				echo '<li class="span4" id="item'.$item->id.'">';
				echo '<div class="thumbnail">';
				echo '<span id="badgeItem'.$item->id.'" class="badgeItem badge badge-success">0</span>';
				echo '<span class="removeItemBadge badge badge-important"  id="removeItem'.$item->id.'">-</span>';
				echo '<span class="removeItemButton" id="removeItemButton'.$item->id.'"></span>' ;
				echo '<img src="http://placehold.it/300x300" />';
				echo '<p>'.$item->name;
				echo '<br/>'.$item->price.'€ </p>';
				echo '</div></li>';
				if($i % 3 == 2 || $i == count($items) -1){
					echo '</ul>' ;
				}
			}
			echo '</div></div></div>';
			
		}
		echo '</div>';
	}

	if($todo == "getDatabaseContent"){
		$res = array();
		$i = 0;
		$categories = getAllCategories();
		foreach($categories as $cat){
			$items = $cat->getMenuItems();
			foreach($items as $item){
				$res[$item->id] = $item ;
			}
		}
		echo json_encode($res);
	}
	
	if($todo == "sendCommand"){
		$content = isset($_POST["content"]) ? $_POST["content"] : null ; 
		$tableId = isset($_POST["tableId"]) ? $_POST["tableId"] : null ;
		$command = createNewCommand($tableId, $content);
		//$commandArray = $command->getItemArray();
		if($command == null){
			echo "<div class='alert alert-error span10 offset1'><h4>Huho !</h4><p>Il y'a eu une erreur et la commande n'a pas pu être envoyée</p></div>";
		} else {
			echo "<div class='row-fluid'>";
			echo "<div class='alert alert-success span10 offset1'>La commande a été prise en compte !</div>";
			echo "</div>";
			foreach($commandArray as $subArray){
				echo "<div class='row-fluid'>";

				echo "<div class='span2 offset1'>";
				echo $subArray[1]." x ";
				echo "</div>";

				echo "<div class='span6'>";
				echo $subArray[0]->name;
				echo "</div>";

				echo "<div class='span2'>";
				$p = $subArray[0]->price * $subArray[1];
				echo $p." €";
				echo "</div>";

				echo "</div>";
			}
			echo "<div class='row-fluid'><hr/></div>";
			echo "<div class='row-fluid'><a href=# id='cancelCommand' class='btn span4 offset1' >Annuler</a><a href=# id='validateCommand' class='btn span4 '>Confirmer</a><div class='span2' id='totalPrice'>".$command->getPrice()." €</div></div>";
		}
	}

	if($todo == "matchTable"){
		$url = isset($_POST["url"]) ? $_POST["url"] : null ;
		$barTableId = matchWithTable($url);
		echo($barTableId);
	}
	
	if($todo == "getNewCommands"){
		$a = getNewCommands();
		echo(json_encode($a));
	}
	
	if($todo == "getAllCommands"){
		$a = getAllCommands();
		echo(json_encode($a));
	}

	}
?>