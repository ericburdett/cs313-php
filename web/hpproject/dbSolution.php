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
    $user = 'postgres';
    $password = 'admin';
    $db = new PDO('pgsql:host=127.0.0.1;dbname=hp',$user,$password);
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
