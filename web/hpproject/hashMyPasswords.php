<?php
//Used simply for hashing my passwords after a database rebuild has taken place.
//All passwords will be set to 'admin'
require 'dbConnect.php';

$hash = password_hash('admin', PASSWORD_DEFAULT);

$stmt = $db->prepare('UPDATE employee
                     SET password = :hash
                     WHERE id < 10
                     ');
$stmt->bindValue(':hash', $hash, PDO::PARAM_STR);
$stmt->execute();

?>