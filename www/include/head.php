<?php require_once "include/sessionHeader.php" ?>
<!Doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="include/style/mainStyle.css">
    <title>Food Talk - <?=$title?></title>

</head>
<body>
<div class="body-wrapper">
<!--    Header    -->
    <div class="header">
        <img class="logo" src="img/foodTalk.png" alt="Logo"> <!--http://d279m997dpfwgl.cloudfront.net/wp/2019/12/promo-art-foodtalk-1000x562.png-->
        <h1 class="title">Food Talk - Postet bis zum satt werden</h1>
    </div>
    <div id="nav" class="nav">
        <a id="home-link" class="link <?php if($active == "home") echo 'active'?>"
           href="index.php"
           onmouseenter="changeIconColor('img/home-active.png', 'home', 'home-link')"
           onmouseleave="changeIconColor('img/home.png', 'home', 'home-link')">
                <?php
                    if($active == "home") echo'<img id="home" src="img/home-active.png" title="Home" alt="Home">';
                    else echo'<img id="home" src="img/home.png" title="Home" alt="Home">';
                ?>

        </a>

        <div id="add-link" class="link"
             onmouseenter="changeIconColor('img/plus-active.png', 'add', 'add-link')"
             onmouseleave="changeIconColor('img/plus.png', 'add', 'add-link')">
                <img id="add" src="img/plus.png" title="Neuest Thema erstellen" alt="Neues Thema erstellen">
        </div>

        <?php
            if(isset($_SESSION['login']) and $_SESSION['login'] == true){
                    echo'  <div class="link-right checkout">
                                <span class="little">Angemeldet als '.$_SESSION['username'].'</span> 
                                <button id="checkout" onclick="checkout()">Checkout</button>
                           </div> ';
            }else
            {
                echo '  <div class="link-right login-container">
                            <form id="login" name="login" method="post" action="include/login.php">
                                <input type="hidden" name="type" value="login">
                                <input name="username" id="username"  type="text" placeholder="Benutzername"  required>
                                <input name="pass" id="pass" type="password" placeholder="Passwort" required>
                                <button id="login-button" type="submit">Login</button>
                            </form>
                        </div>
                        <div class="link-right">
                            <button id="signup" onclick="document.getElementById(\'register-modal\').style.display = \'block\'">Registrieren</button>
                        </div>';
            }
        ?>



    </div>

<!--    Includes the popup window for adding new entrys     -->
    <?php
    require "include/modal.php";
    if(!isset($_SESSION['login']) or !$_SESSION['login'] == true) require_once "include/modalRegister.php";
    ?>
<!--    Content     -->
    <div class="content">