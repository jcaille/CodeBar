<?php
require_once("utils/loader.php");
?>

<!DOCTYPE html>
<HTML>
 <HEAD>
  <TITLE>Code Bar</TITLE>
  <meta name = "viewport" content = "width = 320,initial-scale = 1, user-scalable = no">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
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

 <div id="infoPanel" class="container-fluid">

  <div class="row-fluid flashOrderDrinkIntro">
    <div class="span3 offset1">
      <img src="http://placehold.it/100x100"/>
    </div>
    <div class="span6">
      <h4>Flash</h4>
      <p> Lorem ipsum dolor si tamet  Lorem ipsum dolor si tametLorem ipsum dolor si tametLorem ipsum dolor si tamet</p>
    </div>
  </div>

  <div class="row-fluid flashOrderDrinkIntro">
    <div class="span6 text-right offset1">
      <h4>Order</h4>
      <p> Lorem ipsum dolor si tamet  Lorem ipsum dolor si tametLorem ipsum dolor si tametLorem ipsum dolor si tamet</p>
    </div>
    <div class="span3">
      <img src="http://placehold.it/100x100"/>
    </div>
  </div>

  <div class="row-fluid flashOrderDrinkIntro">
    <div class="span3 offset1">
      <img src="http://placehold.it/100x100"/>
    </div>
    <div class="span6">
      <h4>Drink</h4>
      <p> Lorem ipsum dolor si tamet  Lorem ipsum dolor si tametLorem ipsum dolor si tametLorem ipsum dolor si tamet</p>
    </div>
  </div>

  <div class="row-fluid">
    <input class="span8 offset2" type="number" />
  </div>

  <div class="row-fluid">
    <a href="#" class="btn offset4 span6" id="closeInfoPanel">Afficher la carte</a>
  </div>
</div>

</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/script.js"></script>
<script src="js/bootstrap.min.js"></script>
</BODY>
</HTML>