<?php
session_start();

//Do some authentication stuff...
//If authenticated, then store store variable and redirect

$_SESSION['started'] = true;

header('Location: home.php');

?>