<?php include_once "include/sessionHeader.php" ?>
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
                    if($active == "home") echo'<img id="home" src="img/home-active.png" alt="Home">';
                    else echo'<img id="home" src="img/home.png" alt="Home">';
                ?>

        </a>

        <a class="link" href=""> Test </a>
        <a class="link" href=""> Test </a>

        <div id="add-link" class="link-right"
             onmouseenter="changeIconColor('img/plus-active.png', 'add', 'add-link')"
             onmouseleave="changeIconColor('img/plus.png', 'add', 'add-link')">
                <img id="add" src="img/plus.png" alt="Neues Thema erstellen">
        </div>
    </div>

<!--    Includes the popup window for adding new entrys     -->
    <?php require "include/modal.php"; ?>
<!--    Content     -->
    <div class="content">