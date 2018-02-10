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
<h2>Printers</h2>
<form action="#" method="GET">
  <input type="text" name="value" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  <select class="form-control selectWidth" name="column">
    <option value="model_name" <?php if ($_GET['column'] == 'model_name') { echo 'selected="selected" ';} ?>>Model Name</option>
    <option value="device_class" <?php if ($_GET['column'] == 'device_class') { echo 'selected="selected" ';} ?>>Device Class</option>
    <option value="firmware_type" <?php if ($_GET['column'] == 'firmware_type') { echo 'selected="selected" ';} ?>>Firmware Type</option>
    <option value="mfp" <?php if ($_GET['column'] == 'mfp') { echo 'selected="selected" ';} ?>>MFP/SFP</option>
    <option value="color" <?php if ($_GET['column'] == 'color') { echo 'selected="selected" ';} ?>>Color/Mono</option>
    <option value="duplex" <?php if ($_GET['column'] == 'duplex') { echo 'selected="selected" ';} ?>>Duplex/Simplex</option>
    <option value="supports_sm" <?php if ($_GET['column'] == 'supports_sm') { echo 'selected="selected" ';} ?>>Security Manager</option>
    <option value="sm_inst_on_cap" <?php if ($_GET['column'] == 'sm_inst_on_cap') { echo 'selected="selected" ';} ?>>SM Instant On</option>
    <option value="sure_start" <?php if ($_GET['column'] == 'sure_start') { echo 'selected="selected" ';} ?>>Sure Start</option>
    <option value="whitelisting" <?php if ($_GET['column'] == 'whitelisting') { echo 'selected="selected" ';} ?>>Whitelisting</option>
    <option value="run_time_int_det" <?php if ($_GET['column'] == 'run_time_int_det') { echo 'selected="selected" ';} ?>>Run Time Intrusion Detection</option>
    <option value="connection_inspector" <?php if ($_GET['column'] == 'connection_inspector') { echo 'selected="selected" ';} ?>>Connection Inspector</option>
    <option value="is_a4" <?php if ($_GET['column'] == 'is_a4') { echo 'selected="selected" ';} ?>>A3/A4</option>
  </select><br />
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbPrinter.php" class="btn btn-primary btn-md" role="button">Reset</a>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Model Name</th>
      <th>Device Class</th>
      <th>Firmware Type</th>
      <th>MFP/SFP</th>
      <th>Color/Mono</th>
      <th>Duplex/Simplex</th>
      <th>Security Manager</th>
      <th>SM Instant On</th>
      <th>Sure Start</th>
      <th>Whitelisting</th>
      <th>Run Time Intrusion Detection</th>
      <th>Connection Inspector</th>
      <th>A3/A4</th>
    </tr>
  </thead>
  <tbody>

<?php

$stmt = $db->prepare('SELECT * FROM printer ORDER BY model_name');
$myVal = $_GET['value'];
$myCol = $_GET['column'];

if (isset($myCol) && !empty($myCol)) {
    if ($myCol == 'model_name') {
        $stmt = $db->prepare("SELECT * FROM printer WHERE LOWER($myCol) LIKE LOWER(:val) ORDER BY model_name");
        $stmt->bindValue(':val', '%' . $myVal . '%', PDO::PARAM_STR);
    }
    else {
        if (strtoupper($myVal) == 'YES') {$myVal = 'true';}
        if (strtoupper($myVal) == 'NO') {$myVal = 'false';}
        if (strtoupper($myVal) == 'MFP') {$myVal = 'true';}
        if (strtoupper($myVal) == 'SFP') {$myVal = 'false';}
        if (strtoupper($myVal) == 'COLOR') {$myVal = 'true';}
        if (strtoupper($myVal) == 'MONO') {$myVal = 'false';}
        if (strtoupper($myVal) == 'DUPLEX') {$myVal = 'true';}
        if (strtoupper($myVal) == 'SIMPLEX') {$myVal = 'false';}
        if (strtoupper($myVal) == 'A4') {$myVal = 'true';}
        if (strtoupper($myVal) == 'A3') {$myVal = 'false';}
        $stmt = $db->prepare("SELECT * FROM printer WHERE $myCol = :val ORDER BY model_name");
        $stmt->bindValue(':val', $myVal, PDO::PARAM_STR);
    }
}

$stmt->execute();

foreach($stmt->fetchAll() as $row)
    {
        $mfp = 'SFP';
        $col = 'Mono';
        $dupsim = 'Simplex';
        $supportsSm = 'No';
        $smInstant = 'No';
        $sureStart = 'No';
        $whitelisting = 'No';
        $runtimeIntDet = 'No';
        $connInspector = 'No';
        $a3a4 = 'A3';

        if ($row['mfp'])
            $mfp = 'MFP';
        if ($row['color'])
            $col = 'Color';
        if ($row['duplex'])
            $dupsim = 'Duplex';
        if ($row['supports_sm'])
            $supportsSM = 'Yes';
        if ($row['sm_inst_on_cap'])
            $smInstant = 'Yes';
        if ($row['sure_start'])
            $sureStart = 'Yes';
        if ($row['whitelisting'])
            $whitelisting = 'Yes';
        if ($row['run_time_int_det'])
            $runtimeIntDet = 'Yes';
        if ($row['connection_inspector'])
            $connInspector = 'Yes';
        if ($row['is_a4'])
            $a3a4 = 'A4';

        echo '<tr>';
        echo '<td>' . $row['model_name'] . '</td>';
        echo '<td>' . $row['device_class'] . '</td>';
        echo '<td>' . $row['firmware_type'] . '</td>';
        echo '<td>' . $mfp . '</td>';
        echo '<td>' . $col . '</td>';
        echo '<td>' . $dupsim . '</td>';
        echo '<td>' . $supportsSM . '</td>';
        echo '<td>' . $smInstant . '</td>';
        echo '<td>' . $sureStart . '</td>';
        echo '<td>' . $whitelisting . '</td>';
        echo '<td>' . $runtimeIntDet . '</td>';
        echo '<td>' . $connInspector . '</td>';
        echo '<td>' . $a3a4 . '</td>';
        echo '</tr>';
    }
?>

  </tbody>
</table>


</body>
</div>

</html>
