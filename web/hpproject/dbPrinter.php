<?php
session_start();
?>
<html>
<head>
  <title>Printers</title>
  <script>
    function confirmation(table, id) {
        document.getElementById('insertLabel').innerHTML = '<label for="' + table + '_s' + id + '" class="btn btn-primary tabindex="0">Yes</label>';
        $("#confirmNew").modal("show");
    }

    function update(table, id) {
        document.getElementById('idInput').innerHTML = '<input type="text" name="id" value = "' + id + '" hidden>';
        $("#update").modal("show");
    }
    </script>
</head>

<?php
require 'header.php';
require 'functions.php';

//Get enum types to fill update modal values
$prinClass = $db->prepare('SELECT unnest(enum_range(NULL::deviceClass)) AS class');
$prinClass->execute();
$classes = $prinClass->fetchAll();

$prinFirm = $db->prepare('SELECT unnest(enum_range(NULL::firmwareType)) AS firm');
$prinFirm->execute();
$firmware = $prinFirm->fetchAll();


if (isset($_POST['id'])) {
    $update = $db->prepare('UPDATE printer SET
                            model_name = :modelName,
                            device_class = :class,
                            firmware_type = :firm,
                            mfp = :mfp,
                            color = :color,
                            duplex = :duplex,
                            supports_sm = :supports_sm,
                            sm_inst_on_cap = :sm_inst_on_cap,
                            sure_start = :sure_start,
                            whitelisting = :whitelisting,
                            run_time_int_det = :run_time_int_det,
                            connection_inspector = :connection_inspector,
                            is_a4 = :is_a4
                            WHERE id = :id
                            ');
    $update->bindValue(':id',emptyToNULL($_POST['id']),PDO::PARAM_INT);
    $update->bindValue(':modelName',emptyToNull($_POST['pname']),PDO::PARAM_STR);
    $update->bindValue(':class',emptyToNull($_POST['pclass']),PDO::PARAM_STR);
    $update->bindValue(':firm',emptyToNull($_POST['pfirm']),PDO::PARAM_STR);
    $update->bindValue(':mfp',emptyToNull($_POST['pmfp']),PDO::PARAM_STR);
    $update->bindValue(':color',emptyToNull($_POST['pcolor']),PDO::PARAM_STR);
    $update->bindValue(':duplex',emptyToNull($_POST['pduplex']),PDO::PARAM_STR);
    $update->bindValue(':supports_sm',emptyToNull($_POST['psupports_sm']),PDO::PARAM_STR);
    $update->bindValue(':sm_inst_on_cap',emptyToNull($_POST['psm_inst_on_cap']),PDO::PARAM_STR);
    $update->bindValue(':sure_start',emptyToNull($_POST['psure_start']),PDO::PARAM_STR);
    $update->bindValue(':whitelisting',emptyToNull($_POST['pwhitelisting']),PDO::PARAM_STR);
    $update->bindValue(':run_time_int_det',emptyToNull($_POST['prun_time_int_det']),PDO::PARAM_STR);
    $update->bindValue(':connection_inspector',emptyToNull($_POST['pconnection_inspector']),PDO::PARAM_STR);
    $update->bindValue(':is_a4',emptyToNull($_POST['pis_a4']),PDO::PARAM_STR);

    update($update);
}

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
      <th></th>
    </tr>
  </thead>
  <tbody>

<?php
//Delete
if (isset($_POST['printer'])) {
    $delete = $db->prepare('DELETE FROM printer WHERE id = :id');
    $delete->bindValue(':id',$_POST['printer'],PDO::PARAM_INT);
    delete($delete);
}


//Query
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
        $a3a4 = 'No';

        if ($row['mfp'])
            $mfp = 'MFP';
        else if ($row['mfp'] === NULL)
            $mfp = '';
        if ($row['color'])
            $col = 'Color';
        else if ($row['color'] === NULL)
            $col = '';
        if ($row['duplex'])
            $dupsim = 'Duplex';
        else if ($row['duplex'] === NULL)
            $dupsim = '';
        if ($row['supports_sm'])
            $supportsSM = 'Yes';
        else if ($row['supports_sm'] === NULL)
            $supportsSM = '';
        if ($row['sm_inst_on_cap'])
            $smInstant = 'Yes';
        else if ($row['sm_inst_on_cap'] === NULL)
            $smInstant = '';
        if ($row['sure_start'])
            $sureStart = 'Yes';
        else if ($row['sure_start'] === NULL)
            $sureStart = '';
        if ($row['whitelisting'])
            $whitelisting = 'Yes';
        else if ($row['whitelisting'] === NULL)
            $whitelisting = '';
        if ($row['run_time_int_det'])
            $runtimeIntDet = 'Yes';
        else if ($row['run_time_int_det'] === NULL)
            $runtimeIntDet = '';
        if ($row['connection_inspector'])
            $connInspector = 'Yes';
        else if ($row['connection_inspector'] === NULL)
            $connInspector = '';
        if ($row['is_a4'])
            $a3a4 = 'A4';
        else if ($row['is_a4'] === NULL)
            $a3a4 = '';

        echo '<form action="#" method="POST">
                <input type="text" value="' . $row['id'] . '" name="printer" hidden>
                <input type="submit" id="printer_s' . $row['id'] . '" hidden>
              </form>';

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
        echo '<td>
                <div class="nowrap">
                  <span>
                    <label onclick="confirmation(\'printer\',' . $row['id'] . ')">
                      <small class="float-sm-right tabEntry"><i class="far fa-trash-alt fa-2x"></i></small>
                    </label>
                  </span>
                  <span>
                    <label onclick="update(\'printer\',' . $row['id'] . ')">
                      <small class="float-sm-right tabEntry"><i class="fas fa-edit fa-2x"></i></small>
                    </label>
                  </span>
                </div>
              </td>';
        echo '</tr>';

    }
?>

  </tbody>
</table>


</body>
</div>

<!-- Confirmation -->

  <!-- Deletion Confirm Modal -->
  <div class="modal fade" id="confirmNew" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to delete this row?</h6>
          <p>
            <div id="confirmData"></div>
          </p>
        </div>
        <div class="modal-footer">

          <div id="insertLabel"></div>
<!--          <label for="submitDelete" class="btn btn-primary" tabindex="0">Yes</label> -->
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Update Modal -->
  <div class="modal fade" id="update" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Printer</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
         <form action="#" method="POST" class="card-c">
          <span id="idInput"><!-- Place row id here! --></span>
          <input type="text" id="p-name" name="pname" placeholder="Model Name" class="card-input"><br/>
          <select id="p-class" name="pclass" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($classes as $row)
            {
                echo '<option value="' . $row['class'] . '">' . $row['class'] . '</option>';
            }
           ?>
          </select><br/>
          <select id="p-firm" name="pfirm" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($firmware as $row)
            {
                echo '<option value="' . $row['firm'] . '">' . $row['firm'] . '</option>';
            }
            ?>
          </select><br/>

          <div class="left">
          <h6>MFP/SFP: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pmfp" value="true"> MFP</label>
          <label class="radio-inline"><input type="radio" name="pmfp" value="false"> SFP</label><br/>
          <h6>Color/Mono: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pcolor" value="true"> Color</label>
          <label class="radio-inline"><input type="radio" name="pcolor" value="false"> Mono</label><br/>           
          <h6>Duplex/Simplex: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pduplex" value="true"> Duplex</label>
          <label class="radio-inline"><input type="radio" name="pduplex" value="false"> Simplex</label><br/>
          <h6>Supports Security Manager: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psupports_sm" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psupports_sm" value="false"> No</label><br/>
          <h6>SM Instant On Capability &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psm_inst_on_cap" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psm_inst_on_cap" value="false"> No</label><br/>
          <h6>Sure Start &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psure_start" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psure_start" value="false"> No</label><br/>
          <h6>Whitelisting &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pwhitelisting" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="pwhitelisting" value="false"> No</label><br/>
          <h6>Run Time Intrusion Detection &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="prun_time_int_det" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="prun_time_int_det" value="false"> No</label><br/>
          <h6>Connection Inspector &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pconnection_inspector" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="pconnection_inspector" value="false"> No</label><br/>
          <h6>A3/A4 &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pis_a4" value="false"> A3</label>
          <label class="radio-inline"><input type="radio" name="pis_a4" value="true"> A4</label><br/>
          </div>
          <input type="submit" id="submitPrinter" hidden>
        </form>
        </div>
        <div class="modal-footer">

          <div id="insertLabel"></div>
          <label for="submitPrinter" class="btn btn-primary" tabindex="0">Update</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Success Modal -->
  <div class="modal fade" id="success" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Success!</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>The table was successfully updated.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Error Modal -->
  <div class="modal fade" id="error" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error!</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>There was an error updating the table.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



</html>
