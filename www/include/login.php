<?php
require_once "sessionHeader.php";
require_once "../src/db/db.php";
require_once "../src/User.php";


// Login
try {
    if ($_POST['type'] == "login") {
        $username = $_POST['username'];
        $password = $_POST['pass'];

        if (!User::isValid($username, $password) or $username == "Gast") {
            unset($_POST['username']);
            unset($_POST['pass']);
            throw new Exception("Benutzer oder Passwort falsch.");
        }

        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = User::loadByUsername($username)->getID();

        $_SESSION['success'] = "Willkommen ". $username . ". Du bist erfolgreich angeledet.";
        header("Location: ../index.php");
    }
} catch (Exception $exception) {
    $_SESSION['err_form'] = $exception->getMessage();
    header("Location: ../index.php");
}