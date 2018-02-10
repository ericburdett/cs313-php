<?php
session_start();

//Do some authentication stuff...
//If authenticated, then store store variable and redirect

$_SESSION['started'] = true;

//Store employee_id, so that we can know who's logged in.
$_SESSION['employee_id'] = 1;


header('Location: home.php');

?>