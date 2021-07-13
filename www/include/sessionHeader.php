<?php
$isSessionTrue = session_start();

const SESSIONERRORMESSAGE = "Session konnte nicht gestartet werden. Bitte aktivieren Sie ihre Cookies!";


if(! $isSessionTrue){
    die(SESSIONERRORMESSAGE);
}

getMessage('err');
getMessage('err_form');
getMessage('success');

function getMessage($name)
{
    if(isset($_GET[$name]))
    {
        $_SESSION[$name] = $_GET[$name];
        unset($_GET[$name]);
    }
}

