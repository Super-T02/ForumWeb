<?php
require_once "sessionHeader.php";
require_once "../src/db/db.php";
require_once "../src/Picture.php";
require_once "../src/User.php";

if(isset($_POST['type']))
{
    // Register
    try {
        if ($_POST['type'] == "reg") {
            $username = $_POST['username'];
            $_SESSION['username'] = $_POST['username'];

            if (User::alreadyInDB($username))
            {
                unset($_POST['username']);
                unset($_SESSION['username']);
                throw new Exception("Die Passwörter stimmen nicht überein");
            }

            if ($_POST['pass'] != $_POST['pass2'])
                throw new Exception("Die Passwörter stimmen nicht überein");

            $password = $_POST['pass'];
            $_SESSION['pass'] = $_POST['pass'];

            $myUser = new User($username, $password);

            $myUser->sendToDB();
            $_SESSION['userID'] = $myUser->getId();
        }
    } catch (Exception $exception) {
        echo($exception->getMessage()."<br>".$exception->getTraceAsString());
    }

    // Login
    try {
        if ($_POST['type'] == "login") {
            $username = $_POST['username'];
            $password = $_POST['pass'];

            if (!User::isValid($username, $password)) {
                unset($_POST['username']);
                unset($_POST['pass']);
                throw new Exception("Benutzer oder Passwort falsch.");
            }

            $_SESSION['username'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['pass'];

            $myUser = new User($username, $password);

            $myUser->sendToDB();
            $_SESSION['userID'] = $myUser->getId();
            $_SESSION['login'] = true;
        }
    } catch (Exception $exception) {
        echo($exception->getMessage()."<br>".$exception->getTraceAsString());
    }

}

echo "
<h1>Login</h1>
<form name='createUser' method='post' action='test.php'>
<input type='hidden' name='type' value='login'>
<input name='username' type='text' placeholder='Benutzername'>
<input name='pass' type='password' placeholder='Passwort'><br>
<input type='submit' value='Login'>
</form>

";

echo "
<h1>Registrieren</h1>
<form name='registerUser' method='post' action='test.php'>
<input type='hidden' name='type' value='reg'>
<input name='username' type='text' placeholder='Benutzername' value='";

if (isset($_SESSION['username'])) echo $_SESSION['username'];

echo "' required>
<input name='pass' type='password' placeholder='Passwort' required>
<input name='pass2' type='password' placeholder='Passwort Wiederholen' required>
<br>
<input type='submit' value='Registrieren'>
</form>

";

if(isset($_SESSION['userID'])) echo "<h1>" . $_SESSION['userID'] . "</h1>";

if (isset($_SESSION['login'])) echo "Hallo " . $_SESSION['username'];