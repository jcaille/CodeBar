<?php
require_once("utils/loader.php");
?>

<!DOCTYPE html>
<HTML>
 <HEAD>
  <TITLE>Code Bar</TITLE>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <meta name = "viewport" content = "width = 320,initial-scale = 1, user-scalable = no">
</HEAD>
<BODY>
 <div id="all" class="row-fluid">
   <div id="header" class="navbar navbar-fixed-top">  
     <div class="navbar-inner">  
       <div class="container-fluid">  
        <div id ="tableIcon" class="span2"><img src="image/wait.gif" /></div>
        <h1 class="span8">CodeBar</h1>
        <h2 class="pull-right span2 text-right"><span id="mainItemCount">0</span></h2>
      </div>
    </div>  
  </div>  

  <div id="content" class="row-fluid">
   <div class="progress progress-striped active span4 offset4" id="progressBar">
     <div class="bar" style="width: 100%;"></div>
   </div>
 </div>

 <div id="infoPanel" class="row-fluid">
  <div class="row-fluid">
    <div class="span2" id="rightCollumn"></div>
    <div class="span8" id="mainInfoPanel">
      <div class="alert alert-success">
        <h4>Bienvenue !</h4>
        <p> Pour commander, faites votre choix, puis validez en cliquant sur le caddie.</p>
      </div>
      <div class="alert alert-info" id="infoCheckingTable">
        <p>Une seconde, nous verifions votre table.</p>
      </div>
      <div class="row-fluid">
        <a class="btn span9 offset3" id="closeInfoPanel">Ok, j'ai compris !</a>
      </div>
    </div>
    <div class="span1" id="rightCollumn"></div>
  </div>
</div>

</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/script.js"></script>
<script src="js/bootstrap.min.js"></script>
</BODY>
</HTML>