<?php
session_start();
require 'dbConnect.php';

$pass = $db->prepare('SELECT id, password FROM employee WHERE email = :email');
$pass->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
$pass->execute();

$info = $pass->fetch();

if (password_verify($_POST['pwd'],$info['password'])) {
    $_SESSION['started'] = true;
    $_SESSION['employee_id'] = $info['id'];
    header('Location: home.php');
}
else {
    $_SESSION['started'] = false;
    $_SESSION['invalid'] = true;
    header('Location: index.php');
}


//Do some authentication stuff...
//If authenticated, then store store variable and redirect


//Store employee_id, so that we can know who's logged in.



?>