<?php
session_start();
?>
<html>
<head>
</head>

<?php
require 'header.php';
//require 'dbHeader.php';
?>

<div class="marg">

<body>
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
        $dbopts = parse_url($dbURL);
    
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

<h2>Customers</h2>
<form action="#" method="GET">
  <input type="text" name="value" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  <select class="form-control selectWidth" name="column">
    <option value="name" <?php if ($_GET['column'] == 'name') { echo 'selected="selected" ';} ?>>Name</option>
    <option value="phone" <?php if ($_GET['column'] == 'phone') { echo 'selected="selected" ';} ?>>Phone</option>
    <option value="region" <?php if ($_GET['column'] == 'region') { echo 'selected="selected" ';} ?>>Region</option>
    <option value="type" <?php if ($_GET['column'] == 'type') { echo 'selected="selected" ';} ?>>Type</option>
    <option value="notes" <?php if ($_GET['column'] == 'notes') { echo 'selected="selected" ';} ?>>Notes</option>
  </select><br />
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbCustomer.php" class="btn btn-primary btn-md" role="button">Reset</a>
</form>


<table class="table table-striped">
  <thead>
    <tr>
      <th>Name<span class="caret"></span></th>
      <th>Phone<span class="caret"></span></th>
      <th>Region<span class="caret"></span></th>
      <th>Type<span class="caret"></span></th>
      <th>Notes<span class="caret"></span></th>
    </tr>
  </thead>
  <tbody>
<?php

$stmt = $db->prepare('SELECT * FROM customer ORDER BY name');
$myVal = $_GET['value'];
$myCol = $_GET['column'];

if (isset($myCol) && !empty($myCol)) {
    if ($myCol != 'type' && $myCol != 'region') {
        $stmt = $db->prepare("SELECT * FROM customer WHERE LOWER($myCol) LIKE LOWER(:val) ORDER BY name");
        $stmt->bindValue(':val', '%' . $myVal . '%', PDO::PARAM_STR);
    }
    else {
        $stmt = $db->prepare("SELECT * FROM customer WHERE $myCol = :val ORDER BY name");
        $stmt->bindValue(':val', $myVal, PDO::PARAM_STR);
    }
}

$stmt->execute();
//For Testing

foreach($stmt->fetchAll() as $row)
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
</div>

</html>
