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
    $dbURL = getenv('DATABASE_URL');

    if (empty($dbURL)) {
        $user = 'postgres';
        $password = 'admin';
        $db = new PDO('pgsql:host=127.0.0.1;dbname=hp',$user,$password);
    }
    else {
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
      <th>Email</th>
      <th>Type</th>
      <th>Region</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($db->query('SELECT name,email,type,region FROM employee') as $row)
    {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['region'] . '</td>';
        echo '</tr>';
    }
?>
  </tbody>
</table>


</body>



</html>
