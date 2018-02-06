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

<body>
<?php
try
{
    $dbUrl = getenv('DATABASE_URL');

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
      <th>Phone</th>
      <th>Region</th>
      <th>Type</th>
      <th>Notes</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($db->query('SELECT * FROM customer') as $row)
    {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['phone'] . '</td>';
        echo '<td>' . $row['region'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['notes'] . '</td>';
        echo '</tr>';
    }
?>
  </tbody>
</table>


</body>


</html>
