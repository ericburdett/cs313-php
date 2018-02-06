<?php
session_start()
?>
<html>
<head>
</head>

<?php
require 'header.php';
//require 'dbHeader.php';
?>

<?php
try
{
    $dbUrl = 'postgres://euorzydqbdhxga:39f5be18a29432c4f25d03048d92bc0ffffbfe7dd851110cf0b5552f332
    8be58@ec2-107-21-236-219.compute-1.amazonaws.com:5432/dmg2ku6bjf19b';

    if (empty($dbURL)) {
        echo 'Empty!';
        $user = 'postgres';
        $password = 'admin';
        $db = new PDO('pgsql:host=127.0.0.1;dbname=hp',$user,$password);
    }
    else {
        echo 'Not Empty';
        $dbopts = parse_url($dbUrl);
    
        $dbHost = $dbopts["host"];
        $dbPort = $dbopts["port"];
        $dbUser = $dbopts["user"];
        $dbPassword = $dbopts["pass"];
        $dbName = ltrim($dbopts["path"],'/');

        $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    }
}
catch (PDOException $ex)
{
    echo 'Error!: ' . $ex->getMessage();
    die();
}
?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($db->query('SELECT * FROM solution') as $row)
    {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '</tr>';
    }
?>
  </tbody>
</table>


</body>



</html>
