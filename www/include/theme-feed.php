<?php
require_once "src/Theme.php";
require_once "src/Picture.php";

if(isset($_GET['themeID']))
{
    $ID = $_GET['themeID'];

    try {
        //Get theme by ID
        $theme = Theme::loadByID($ID);
        $theme->increaseViews();

        echo $theme;

        //Print modal for new Answers
        require_once "include/answerModal.php";
    } catch (Exception $e) {
        //If there is any error the user will be send to the index page
        $_SESSION['err'] = "Ein Fehler ist aufgetreten: ". $e->getMessage();
        header("Location: ../index.php?err=".$_SESSION['err']);
    }
}
else
{
    $_SESSION['err'] = "Dieser Artikel existiert nicht.";
    header("Location: ../index.php?err=".$_SESSION['err']);
}