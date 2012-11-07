$(document).ready(function(){
	
	var globalDTB = null ;
	var globalCommand = [null] ;

	// Hide the adress Bar
	setTimeout(function(){
		window.scrollTo(0, 1);
	}, 0);

	//Function to get the url parts
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	$("#infoPanel").hide();

	$("#closeInfoPanel").click(function(){
		$("#infoPanel").slideUp("fast");
	})

	//Check if the table is correct
	var r = Math.floor((Math.random()*10000000)+1);
	$.post(
		"utils/ajax.php?todo=matchTable&ios6fix="+r,
		{"url" : getUrlVars()["url"]},
		function(text){
			if(parseInt(text) > 0){
				var barTableId = parseInt(text);
				$("#tableIcon").html("<h2>:)</h2>");
				$("#infoCheckingTable").html("<p>Nous avons verifie votre table ! Vous pouvez maintenant commander !</p>");
				//Bind the click on item count to command validation
				$("#mainItemCount").click(function(){
					var command = globalCommand;
					var sum = 0 ;
					for(i =1 ; i < command.length ; i++){
						sum += command[i] ;
					}
					if(sum == 0){
						alert("Nothing was ordered");
						return false ;
					}
					if(sum =! parseInt($("#mainItemCount").html())){
						alert("There was a problem with the command");
						return false ;
					}
					$("#infoPanel").html("");

					while(globalDTB == null){
						//try to load database
						alert("database is not loaded");
					}
					var infoText = "" ;
					infoText += '<div class="alert alert-info span10 offset1" id="commandConfirmation">Voici votre commande :</div>';
					var checkoutSum = 0;
					for( i=1 ; i<command.length ; i++){
						if(command[i] > 0){
							var rowText = "";
							rowText += "<div class='span2 offset1'>"+command[i]+" x </div>";
							rowText += "<div class='span6'>"+globalDTB[i].name+"</div>";
							rowText += "<div class='span2 text-right'>"+ (command[i]*globalDTB[i].price) +" &euro; </div>";
							infoText += "<div class='row-fluid'>"+rowText+"</div>";
							checkoutSum += command[i]*globalDTB[i].price
						}
					}
					infoText += "<div class='row-fluid'><hr/></div>";
					infoText += "<div class='row-fluid' id='finalRow'><a href=# id='cancelCommand' class='btn span4 offset1' >Annuler</a><a href=# id='validateCommand' class='btn span4 '>Confirmer</a><div class='span2 text-right' id='totalPrice'>"+checkoutSum+" &euro;</div>";
					displayInfoPanel(infoText, "#cancelCommand");

					$("#validateCommand").click(function(){
						var json_command = JSON.stringify(command);
						var r = Math.floor((Math.random()*10000000)+1);
						$("#validateCommand").html("<img src='image/wait.gif' height='15' width='15'/>");
						$.post(
							"utils/ajax.php?todo=sendCommand&ios6fix="+r,
							{"tableId" : barTableId , "content" : json_command},
							function(){
								//test for errors
								$("#validateCommand").hide();
								$("#cancelCommand").hide();
								$("#finalRow").prepend("<div class='alert alert-success span8 offset1'> La commande est partie </div>");								
							});
					})
				})
} else {
	$("#tableIcon").html("<h2>:(</h2>");
		$("#infoCheckingTable").html("<p> Huho ! IL y'a eu un petit probleme avec la verification de la table. Essayez de flasher le code de nouveaux !</p>");
		$("#infoCheckingTable").removeClass("alert-info");
		$("#infoCheckingTable").addClass("alert-error");
	}
})

	//Loads the database
	$.post(
		"utils/ajax.php?todo=getDatabaseContent&ios6fix="+r,
		null,
		function(text){
			globalDTB = JSON.parse(text);
		})

	//Charge the menu
	$.post(
		"utils/ajax.php?todo=displayCategoriesAccordion&ios6fix="+r,
		null,
		function(text){
			$("#content").html(text);
			$(".collapse").collapse();
			updateBadgesBasedOnCommand();
			$(".thumbnails li").click(function(){
				var id = $(this).attr("id").substring(4);
				addOne(id);
			})
			$(".removeItemButton").click(function(){
				var id = $(this).attr("id").substring(16);
				// alert(id);
				substractOne(id);
				substractOne(id);
			})
		})


	function updateBadges(){
		$(".badgeItem").each(function(){
			var id = parseInt($(this).attr("id").substring(9));
			if($(this).html() == 0){
				$(this).hide();
				$("#removeItem"+id).hide();
			} else {
				$(this).show();
				$("#removeItem"+id).show();
			}
		})
		$(".badgeCategory").each(function(){
			if($(this).html() == 0){
				$(this).hide();
			} else {
				$(this).show();
			}
		})
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
		if(globalDTB != null) {
			for(var i in globalDTB){
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
						if(categoryCount[globalDTB[i].categoryId] == null){
							categoryCount[globalDTB[i].categoryId] = globalCommand[i] ;
						} else {
							categoryCount[globalDTB[i].categoryId] += globalCommand[i] ;
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

	function addOneTo(item){
		var badge = $(item).children().children(".badgeItem");
		var current = parseInt($(badge).html());
		$(badge).html(current+1);
		
		var categoryId = parseInt($(item).parent().parent().parent().attr("id").substring(8));
		var categoryBadge = $("#badgeCategory"+categoryId);
		var categoryCurrent = parseInt($(categoryBadge).html());
		$(categoryBadge).html(categoryCurrent +1);
		
		var mainCurrent = parseInt($("#mainItemCount").html());
		$("#mainItemCount").html(mainCurrent + 1);	
		updateBadges();	
	}
	
	function substractOneTo(item){
		var badge = $(item).children().children(".badgeItem");
		var current = parseInt($(badge).html());
		$(badge).html(current-1);
		
		var categoryId = parseInt($(item).parent().parent().parent().attr("id").substring(8));
		var categoryBadge = $("#badgeCategory"+categoryId);
		var categoryCurrent = parseInt($(categoryBadge).html());
		$(categoryBadge).html(categoryCurrent - 1);
		
		var mainCurrent = parseInt($("#mainItemCount").html());
		$("#mainItemCount").html(mainCurrent - 1);	
		
		updateBadges();	
	}

	function displayInfoPanel(text, closeButtonId){
		$("#infoPanel").html(text);
		$(closeButtonId).click(function(){
			$("#content").show();
			$("#infoPanel").slideUp("fast");
		})
		$("#infoPanel").slideDown("fast", function(){
			$("#content").hide();
			if($("#infoPanel").height() < $(window).height()){
				var additional_padding = $(window).height() - 40 - $("#infoPanel").height();
				$("#infoPanel").css("padding-bottom",additional_padding+"px");			
			} else {
				alert("Huho !");
				$("#infoPanel").css("padding-bottom", "15px");
			}
		});
	}

})