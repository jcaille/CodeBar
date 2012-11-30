$(document).ready(function(){

	if (/OS 6_/.test(navigator.userAgent)) {
	  $.ajaxSetup({ cache: false });
	}

	$.post(
		"utils/ajax.php?todo=getAllCommands",
		null,
		function(text){
			// alert(text);
			var commandList = JSON.parse(text);
			for(var i = 0 ; i < commandList.length ; i++){
				prependCommand(commandList[i]);
			}
			updateCommandCount()
		})

	getNewCommands();

	function updateCommandCount(){
		var totalNumberOfCommand = $(".command").size() ;
		var fulfilledCommands = $(".command.muted").size() ;

		$("#actualNumberOfWaitingCommands").html(totalNumberOfCommand - fulfilledCommands) ;
	}

	function validateCommand(id){
		var r = Math.floor((Math.random()*10000000)+1);
		$.post(
			"utils/ajax.php?todo=validateCommand&commandId="+id+"&ios6fix="+r,
			null,
			function(text){
				$("#command"+id).addClass("muted");
				$("#validateCommand"+id).unbind('click');
				updateCommandCount();
			})
	}

	function getNewCommands(){
		// alert("Hello");
		var r = Math.floor((Math.random()*10000000)+1);
		$.post(
			"utils/ajax.php?todo=getNewCommands&ios6fix="+r,
			null,
			function(text){
				var commandList = JSON.parse(text);
				for(var i = 0 ; i < commandList.length ; i++){
					prependCommand(commandList[i]);
				}
			})
		updateCommandCount();
		setTimeout(getNewCommands, 10000);
	}

	function prependCommand(command){
		// alert(JSON.stringify(command));
		var s = "";
		if(command.state == "fulfilled"){
			s += "<div class='row muted command' id='command"+command.id+"'>" ;
		} else {
			s += "<div class='row command' id='command"+command.id+"'>" ;
		}
		s += "<div class='span2'><h1>"+command.barTableShortName+"</h1><h6>"+command.creationTime+"</h6></div>";
		s += "<div class='span8'><ul>" ;
		for(var i = 0 ; i < command.content.length ; i++){
			var item = command.content[i][0];
			var quantity = command.content[i][1];
			s += "<li>" + quantity + " x " + item.name + "</li>" ; 
		}
		s += "</ul></div>";
		s += "<div class='span2'>";
		s += "<h1 class='text-right'>"+command.price+" &euro;</h1><hr/>";
		s += "<a class='btn btn-large pull-right validateCommand' id='validateCommand"+command.id+"'>Valider</a>";
		s += "</div></div><hr/>";
		$("#content").prepend(s);

		$("#validateCommand"+command.id).bind('click', function(){
			validateCommand(command.id);
		})

	}
})