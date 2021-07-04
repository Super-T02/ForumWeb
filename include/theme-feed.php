<?php
require_once "src/Theme.php";

if(isset($_GET['themeID']))
{
    $ID = $_GET['themeID'];

    try {
        //Get them by ID
        $theme = Theme::loadByID($ID);
        echo $theme;

        //Print modal for new Answers
        require_once "include/answerModal.php";
    } catch (Exception $e) {
        //If there is any error the user will be send to the index page
        $_SESSION['err'] = "Dieser Artikel existiert nicht.";
        header("Location: index.php");
    }
}
else
{
    $_SESSION['err'] = "Dieser Artikel existiert nicht.";
    header("Location: index.php");
}