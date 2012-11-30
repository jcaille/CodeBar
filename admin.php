<?php
require_once("utils/loader.php");
?>

<!DOCTYPE html>
<HTML>
 <HEAD>
  <TITLE>Code Bar - Administration</TITLE>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/admin.css">
  <meta name = "viewport" content = "width = 320,initial-scale = 1, user-scalable = no">
</HEAD>
<BODY>
 <div id="header">
  <div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
      <a class="brand" href="#">CodeBar <span id="waitingCommand"> - <span id="waitingCommandCount"> <span id="actualNumberOfWaitingCommands">0</span> commandes en attente</span></a>
      <ul class="nav">
        <li class="active"><a href="#">Commandes</a></li>
      </ul>
    </div>
  </div>
 </div> 
 <div id="content" class="container">
 </div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/admin.js"></script>
<script src="js/bootstrap.min.js"></script>
</BODY>
</HTML>