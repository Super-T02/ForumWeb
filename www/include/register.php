<?php

require_once "../src/User.php";

// Register
try {
    $username = $_POST['username'];

    if (User::alreadyInDB($username))
    {
        unset($_POST['username']);
        throw new Exception("Der Benutzer existiert bereits!");
    }

    if ($_POST['pass'] != $_POST['pass2']){
        $_SESSION['username'] = $username;
        throw new Exception("Die Passwörter stimmen nicht überein");
    }

    $password = $_POST['pass'];

    $myUser = new User($username, $password);

    $myUser->sendToDB();
    $_SESSION['userID'] = $myUser->getId();
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;

    $_SESSION['success'] = "Hallo ".$username.". Du hast dich erfolgreich registriert.";
    header("Location: ../index.php?success=".$_SESSION['success']);

} catch (Exception $exception) {
    $_SESSION['err_form'] = $exception->getMessage();
    header("Location: ../index.php?err=".$_SESSION['err_form']);
}