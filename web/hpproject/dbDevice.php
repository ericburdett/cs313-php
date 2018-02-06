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
foreach($db->query('SELECT * FROM printer') as $row)
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

</html>
