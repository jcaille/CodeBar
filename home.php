<?php
require_once("utils/loader.php");
?>

<!DOCTYPE html>
<HTML>
<HEAD>
    <TITLE>Code Bar</TITLE>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'></HEAD>
<BODY>

    <div id="top-hero" class="hero-unit">
        <h1>CodeBar</h1>
        <h3>Flash, Order, Drink.</h3>
    </div>

    <div class='container' id='aboutUsContainer'>
        <div id="description" class='row'>

            <div class='span6'>
                <h2>Flash, Order, Drink</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                </p>
            </div>

            <div class='span6'>
                <h2>Notre solution</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                </p>
            </div>
        </div>
    </div>

    <div id="flashOrderDrink-hero">
        <div class='container'>
            <div class='row'>
                <div class='span4'>
                    <img src='http://placehold.it/100x100'>
                    <h4>Un nouveau moyen pour vos clients de commander</h4>
                </div>
                <div class='span4'>
                    <img src='http://placehold.it/100x100'>
                    <h4>Votre carte, accessible en ligne a tout moment</h4>
                </div>
                <div class='span4'>
                    <img src='http://placehold.it/100x100'>
                    <h4>Lorem Ipsum dolor Sit Amet with some filler text</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="moreInfo" class='row'>
        <div class='span6'>
            <h2>En savoir plus</h2>
            <p>
                Laissez nous vos informations de contact et nous vous enverrons un e-mail.
            </p>
            <form class="form-horizontal" action="MAILTO:jcaille+codebar@gmail.com" method="post">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Votre Email</label>
                    <div class="controls">
                        <input type="text" id="inputEmail" placeholder="monbar@gmail.com">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>

        <div class='span6'>
            <h2>Tester le produit</h2>
            <p>
                Flashez tout simplement le code ci-dessous pour tester notre service.
            </p>
            <div id='exampleCode'>
                <img   src='image/example_code.png'>
            </div>
        </div>

    </div>
    <div id='aboutUs'>
        <hr/>
        <div class='row'>
        <div class='span3'>
            <div class='row'>
                <div class='span1'>
                    <img src='http://placehold.it/75x75' class='img-circle'>
                </div>
                <div class='span2'>
                    <p><strong> Michel Jautzy </strong><br/>
                     Description </p>
                </div>
            </div>
        </div>

        <div class='span3'>
            <div class='row'>
                <div class='span1'>
                    <img src='http://placehold.it/75x75' class='img-circle'>
                </div>
                <div class='span2'>
                    <p>
                        <strong> Daniel Jautzy </strong>
                        <br/> Description 
                    </p>
                </div>
            </div>
        </div>

        <div class='span3'>
            <div class='row'>
                <div class='span1'>
                    <img src='http://placehold.it/75x75' class='img-circle'>
                </div>
                <div class='span2'>
                    <p>
                        <strong> Jeremy Saada </strong>
                        <br/> Description 
                    </p>
                </div>
            </div>
        </div>

        <div class='span3'>
            <div class='row'>
                <div class='span1'>
                    <img src='http://placehold.it/75x75' class='img-circle'>
                </div>
                <div class='span2'>
                    <p>
                        <strong> Jean Caille </strong>
                        <br/> Description 
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>


<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/home.js"></script>
</BODY>
</HTML>