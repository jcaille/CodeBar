$(document).ready(function(){

	//Global variables
	var globalTableId = -1 ;
	var globalDTB = null ;
	var globalItemDTB = null ;
	var globalCommand = [null] ;
	
	//ios6 fix
	if (/OS 6_/.test(navigator.userAgent)) {
		$.ajaxSetup({ cache: false });
	}

	$("#closeInfoPanel").hide() ;
	setInfoPanelToFill() ;
	$("#closeInfoPanel").click(function(){
		$("#infoPanel").slideUp("fast");
	})

	$.post("utils/ajax.php?todo=getInitialData",
		{"url" : getUrlVars()["url"]},
		function(text){
			var jsonInitialData = JSON.parse(text) ;
			if(checkTable(jsonInitialData.table)){
				$("#closeInfoPanel").show() ;
				globalDTB = jsonInitialData.database ;
				globalItemDTB = jsonInitialData.database.items ;
				menu();
			} else {
				$("#tableIcon").html("<h2>:(</h2>");
			}
		}
	)

	function menu(){
		globalCommand = [null] ;
		displayMenu(globalDTB);
		$("#tableIcon").html("<h2>:)</h2>");
		//Bind the click on item count to command validation
		$("#mainItemCount").click( processPotentialCommand );
		$("#processCommand").click( processPotentialCommand );
	}

	function processPotentialCommand(){
		if(checkCommandContent(globalCommand)){
			checkout() ;
		}
	}

	function checkout(){
		displayCommand(globalCommand);
		$("#validateCommand").click(function(){
			sendCommand(globalCommand);
		});
	}

	function sendCommand(command){
		if(checkCommandContent(command) && checkTable(globalTableId)){
			var json_command = JSON.stringify(command);
			var r = Math.floor((Math.random()*10000000)+1);
			$("#validateCommand").html("<img src='image/wait.gif' height='15' width='15'/>");
			$.post(
				"utils/ajax.php?todo=sendCommand&ios6fix="+r,
				{"tableId" : globalTableId , "content" : json_command},
				function(text){
					if(text == 'true'){
						acknowledgeCommandResult() ;
					} else {
						errorDuringCommand() ;
					}
				});
		}
	}

	function acknowledgeCommandResult(){
		$("#finalRow").fadeOut("slow", function(){
			$("#finalRow").html("<div class='alert alert-success span8 offset1'> La commande est partie </div>");
			$("#finalRow").fadeIn("slow");
			$("#infoPanel").append("<div class='row-fluid'><a class='btn btn-primary span6 offset3' id='newCommand'>Nouvelle Commande</a></div>");
			$("#newCommand").click(function(){
				$("#content").show();
				$(".collapse").collapse("hide");
				globalCommand = [null] ;
				updateBadgesBasedOnCommand();
				$("#infoPanel").slideUp("fast");
			})								
		});
	}

	function errorDuringCommand(){
		$("#validateCommand").html("Confirmer");
		$("#finalRow").prepend("<div class='row-fluid' id='errorDuringCommand'></div>") ;
		$("#errorDuringCommand").hide() ;
		$("#errorDuringCommand").html("<div class='alert alert-error span10 offset1'> Il y a eu un probleme. Essayez de renvoyer la commande dans quelques instants</div>");
		$("#errorDuringCommand").slideDown();
		setTimeout(function() {
			$("#errorDuringCommand").slideUp("slow", function(){
				$("#errorDuringCommand").remove();
			});
		}, 5000);
	}

	//CHECK
	
	//Check that the table number is OK. If yes, stores it in a global variable and returns true
	function checkTable(barTableId){
		if (barTableId > 0){
			globalTableId = barTableId ;
			return true ;
		}
		return false ;
	}

	//Returns true if and only if the command is valid.
	function checkCommandContent(command){
		var sum = 0 ;
		for(i =1 ; i < command.length ; i++){
			sum += command[i] ;
		}
		if(sum == 0){
			alert("Vous n'avez rien commandé");
			return false ;
		}
		if(sum =! parseInt($("#mainItemCount").html())){
			alert("Il y'a un problème avec votre commande");
			return false ;
		}
		return true ;
	}

	//DISPLAY

	function menuHtml(database){
		var htmlString = "" ;
		htmlString += '<div class="row-fluid"><div class="accordion" id="categoryAccordion">';
		for(var i = 0 ; i < database.categories.length ; i++){
			var cat = database.categories[i].category ;
			var categoryItems = database.categories[i].items ;
			htmlString += '<div class="accordion-group" id="category' + cat.name + '">';
			htmlString += '<div class="accordion-heading row-fluid">';
			htmlString += '<a class="accordion-toggle" data-toggle="collapse" data-parent=".accordion" href="#collapse' + cat.id + '">';
			htmlString += "<h4 class='span10'>" + cat.name + "</h4>" ;
			htmlString += '<span id="badgeCategory' + cat.id + '" class="badgeCategory badge badge-success pull-right">0</span>';
			htmlString += '</a></div><div id="collapse' + cat.id + '" class="accordion-body collapse">';
			htmlString += '<div class="accordion-inner">';
			for(var j = 0 ; j < categoryItems.length ; j++){
				var item = database.items[categoryItems[j]]
				htmlString += "<div class='container-fluid item' id='item" + item.id + "'>" ;

				htmlString += "<div class='span3'>" ;
				if(item.pictureFile == ''){
					htmlString += '<img src="http://placehold.it/300x300" />';
				} else {
					htmlString += '<img src="' + item.pictureFile + '" />';
				}
				htmlString += "</div>" ;

				htmlString += "<div class='span8'>" ;
				htmlString += '<h3>' +  item.name  + '</h3>';
				htmlString += '<p><strong>' + item.price + '&euro; </strong>';
				if(item.description != ''){
					htmlString  += ' - '  +  item.description ;
				}
				htmlString += '</p>';
				htmlString += "</div>" ;

				htmlString += "<div class='span1'>" ;
				htmlString += '<span id="badgeItem' + item.id + '" class="badgeItem badge badge-success">0</span>';
				htmlString += '<span class="removeItemBadge badge badge-important"  id="removeItem' + item.id + '">-</span>';
				htmlString += '<span class="removeItemButton" id="removeItemButton' + item.id + '"></span>' ;
				htmlString += "</div>" ;


				htmlString += '</div>' ;
				if( j != categoryItems.length -1 ){
					htmlString += "<hr/>" ;
				}
			}
			htmlString += '</div></div></div>';
			
		}
		htmlString += '</div></div>';
		htmlString += '<div class="row-fluid">' ;
		htmlString += '<a class="btn btn-primary offset3 span6" id="processCommand">Commander</a>' ;

		return htmlString
	}

	function displayMenu(database){
		$("#content").html(menuHtml(database));
		//$(".collapse").collapse('hide')
		updateBadgesBasedOnCommand();
		$(".item").click(function(){
			var id = $(this).attr("id").substring(4);
			addOne(id);
		})
		$(".removeItemButton").click(function(){
			var id = $(this).attr("id").substring(16);
			substractOne(id);
			substractOne(id);
		})
	}

	function displayInfoPanel(text, closeButtonId){
		$("#infoPanel").html(text);
		$(closeButtonId).click(function(){
			$("#content").show();
			$("#infoPanel").slideUp("fast");
		})
		$("#infoPanel").slideDown("fast", function(){
			$("#content").hide();
			setInfoPanelToFill();
		});
	}

	function displayCommand(command){
		var infoText = "" ;
		infoText += '<div class="row-fluid">' ;
		infoText += '<div class="alert alert-info span10 offset1" id="commandConfirmation">Voici votre commande :</div>';
		infoText += '</div>' ;
		var checkoutSum = 0;
		for( i=1 ; i<command.length ; i++){
			if(command[i] > 0){
				var rowText = "";
				rowText += "<div class='span2 offset1'>"+command[i]+" x </div>";
				rowText += "<div class='span6'>"+globalItemDTB[i].name+"</div>";
				rowText += "<div class='span2 text-right'>"+ (command[i]*globalItemDTB[i].price) +" &#8364; </div>";
				infoText += "<div class='row-fluid'>"+rowText+"</div>";
				checkoutSum += command[i]*globalItemDTB[i].price
			}
		}
		infoText += "<div class='row-fluid'><hr/></div>";
		infoText += "<div class='row-fluid'><span id='finalRow'><a href=# id='cancelCommand' class='btn span4 offset1' >Annuler</a><a href=# id='validateCommand' class='btn span4 '>Confirmer</a></span><div class='span2 text-right' id='totalPrice'>"+checkoutSum+" &#8364;</div>";
		displayInfoPanel(infoText, "#cancelCommand");
	}

	//COMMUNICATE

	//UTILS

	//Returns variable that are stored in the URL
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value.replace("#", "");
		});
		return vars;
	}

	function setInfoPanelToFill(){
		if($("#infoPanel").height() < $(window).height()){
			var additional_padding = $(window).height() - 40 - $("#infoPanel").height();
			$("#infoPanel").css("padding-bottom",additional_padding+"px");			
		} else {
			$("#infoPanel").css("padding-bottom", "15px");
		}
	}

	function getCommandContent(){
		var res = new Array() ;
		$(".badgeItem").each(function(){
			var id = parseInt($(this).attr("id").substring(9));
			var quantity = parseInt($(this).html());
			res[id] = quantity ;
		})
		return res ;
	}

	function addOne(id){
		if (globalCommand[id] == null) {
			globalCommand[id] = 1 ;
		} else {
			globalCommand[id] += 1;
		}
		updateBadgesBasedOnCommand();
	}

	function substractOne(id){
		globalCommand[id] -= 1 ;
		updateBadgesBasedOnCommand() ;
	}

	function updateBadgesBasedOnCommand(){
		var categoryCount = new Array() ;
		var totalCount = 0 ;
		$(".badgeItem").hide();
		$(".removeItemBadge").hide();
		$(".removeItemButton").hide();
		$(".badgeCategory").hide();
		if(globalItemDTB != null) {
			for(var i in globalItemDTB){
				if(i != 0 ){
					if( i >= globalCommand.length){
						$("#badgeItem"+i).html("0");
					} else {
						$("#badgeItem"+i).html(globalCommand[i]);
					}
					if(globalCommand[i]>0){
						$("#badgeItem"+i).show();
						$("#removeItem"+i).show();
						$("#removeItemButton"+i).show();
						if(categoryCount[globalItemDTB[i].categoryId] == null){
							categoryCount[globalItemDTB[i].categoryId] = globalCommand[i] ;
						} else {
							categoryCount[globalItemDTB[i].categoryId] += globalCommand[i] ;
						}
						totalCount += globalCommand[i] ;
					} else {
						$("#badgeItem"+i).hide();
						$("#removeItemButton"+i).hide();
						$("#removeItem"+i).hide();
					}
				}
			}
			for(var i = 1 ; i < categoryCount.length ; i++){
				$("#badgeCategory"+i).html(categoryCount[i]);
				if(categoryCount[i] > 0){
					$("#badgeCategory"+i).show();
				} else {
					$("#badgeCategory"+i).hide();
				}
			}
			$("#mainItemCount").html(totalCount);
		}
	}
})