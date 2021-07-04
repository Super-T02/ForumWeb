<?php
$isSessionTrue = session_start();

const SESSIONERRORMESSAGE = "Session konnte nicht gestartet werden. Bitte aktivieren Sie ihre Cookies!";

if(! $isSessionTrue){
    die(SESSIONERRORMESSAGE);
}

checkError('err');
checkError('err_form');

//Function definitions
/**
 * @param $name
 */
function checkError($name)
{
    if (isset($_SESSION[$name]) and is_string($_SESSION[$name]))
    {
        echo ($_SESSION[$name]);
        unset($_SESSION[$name]);
    }
}