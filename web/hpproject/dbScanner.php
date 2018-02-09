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
<div class="marg">
<body>

<h2>Scanners</h2>
<form action="#" method="GET">
  <input type="text" name="value" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  <select class="form-control selectWidth" name="column">
    <option value="model_name" <?php if ($_GET['column'] == 'model_name') { echo 'selected="selected" ';} ?>>Model Name</option>
    <option value="device_class" <?php if ($_GET['column'] == 'device_class') { echo 'selected="selected" ';} ?>>Device Class</option>
    <option value="firmware_type" <?php if ($_GET['column'] == 'firmware_type') { echo 'selected="selected" ';} ?>>Firmware Type</option>
    <option value="flatbed" <?php if ($_GET['column'] == 'flatbed') { echo 'selected="selected" ';} ?>>Flatbed</option>
    <option value="adf" <?php if ($_GET['column'] == 'adf') { echo 'selected="selected" ';} ?>>ADF</option>
    <option value="sheet_feed" <?php if ($_GET['column'] == 'sheet_feed') { echo 'selected="selected" ';} ?>>Sheet Feed</option>
  </select><br />
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbScanner.php" class="btn btn-primary btn-md" role="button">Reset</a>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Model Name</th>
      <th>Device Class</th>
      <th>Firmware Type</th>
      <th>Flatbed</th>
      <th>ADF</th>
      <th>Sheet Feed</th>
    </tr>
  </thead>
  <tbody>

<?php

$stmt = $db->prepare('SELECT * FROM scanner ORDER BY model_name');
$myVal = $_GET['value'];
$myCol = $_GET['column'];

if (isset($myCol) && !empty($myCol)) {
    if ($myCol == 'model_name') {
        $stmt = $db->prepare("SELECT * FROM scanner WHERE LOWER($myCol) LIKE LOWER(:val) ORDER BY model_name");
        $stmt->bindValue(':val', '%' . $myVal . '%', PDO::PARAM_STR);
    }
    else {
        if (strtoupper($myVal) == 'YES') {$myVal = 'true';}
        if (strtoupper($myVal) == 'NO') {$myVal = 'false';}
        $stmt = $db->prepare("SELECT * FROM scanner WHERE $myCol = :val ORDER BY model_name");
        $stmt->bindValue(':val', $myVal, PDO::PARAM_STR);
    }
}

$stmt->execute();
//For Testing

foreach($stmt->fetchAll() as $row)
    {
        $flatbed = 'No';
        $adf = 'No';
        $sheet_feed = 'No';

        if ($row['flatbed'])
            $flatbed = 'Yes';
        if ($row['adf'])
            $adf = 'Yes';
        if ($row['sheet_feed'])
            $sheet_feed = 'Yes';

        echo '<tr>';
        echo '<td>' . $row['model_name'] . '</td>';
        echo '<td>' . $row['device_class'] . '</td>';
        echo '<td>' . $row['firmware_type'] . '</td>';
        echo '<td>' . $flatbed . '</td>';
        echo '<td>' . $adf . '</td>';
        echo '<td>' . $sheet_feed . '</td>';
        echo '</tr>';
    }
?>

  </tbody>
</table>

</body>
</div>

</html>
