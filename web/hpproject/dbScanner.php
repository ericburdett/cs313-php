<?php
session_start();
?>
<html>
<head>
  <title>Scanners</title>
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

$prinClass = $db->prepare('SELECT unnest(enum_range(NULL::deviceClass)) AS class');
$prinClass->execute();
$classes = $prinClass->fetchAll();

$prinFirm = $db->prepare('SELECT unnest(enum_range(NULL::firmwareType)) AS firm');
$prinFirm->execute();
$firmware = $prinFirm->fetchAll();

if (isset($_POST['id'])) {
    $update = $db->prepare('UPDATE scanner SET
                            model_name = :name,
                            device_class = :class,
                            firmware_type = :firm,
                            flatbed = :flatbed,
                            adf = :adf,
                            sheet_feed = :sheet_feed
                            WHERE id = :id
                            ');
    $update->bindValue(':id',emptyToNull($_POST['id']),PDO::PARAM_INT);
    $update->bindValue(':name',emptyToNull($_POST['scname']),PDO::PARAM_STR);
    $update->bindValue(':class',emptyToNull($_POST['scclass']),PDO::PARAM_STR);
    $update->bindValue(':firm',emptyToNull($_POST['scfirm']),PDO::PARAM_STR);
    $update->bindValue(':flatbed',emptyToNull($_POST['scflatbed']),PDO::PARAM_STR);
    $update->bindValue(':adf',emptyToNull($_POST['scadf']),PDO::PARAM_STR);
    $update->bindValue(':sheet_feed',emptyToNull($_POST['scsheet_feed']),PDO::PARAM_STR);
     
    update($update);
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
      <th></th>
    </tr>
  </thead>
  <tbody>

<?php
//Delete
if (isset($_POST['scanner'])) {
    $delete = $db->prepare('DELETE FROM scanner WHERE id = :id');
    $delete->bindValue(':id',$_POST['scanner'],PDO::PARAM_INT);
    delete($delete);
}

//Query
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
        else if ($row['flatbed'] === NULL)
            $flatbed = '';
        if ($row['adf'])
            $adf = 'Yes';
        else if ($row['adf'] === NULL)
            $adf = '';
        if ($row['sheet_feed'])
            $sheet_feed = 'Yes';
        else if ($row['sheet_feed'] === NULL)
            $sheet_feed = '';


        echo '<form action="#" method="POST">
                <input type="text" value="' . $row['id'] . '" name="scanner" hidden>
                <input type="submit" id="scanner_s' . $row['id'] . '" hidden>
              </form>';

        echo '<tr>';
        echo '<td>' . $row['model_name'] . '</td>';
        echo '<td>' . $row['device_class'] . '</td>';
        echo '<td>' . $row['firmware_type'] . '</td>';
        echo '<td>' . $flatbed . '</td>';
        echo '<td>' . $adf . '</td>';
        echo '<td>' . $sheet_feed . '</td>';
        echo '<td>
                <div class="nowrap">
                  <span>
                    <label onclick="confirmation(\'scanner\',' . $row['id'] . ')">
                      <small class="float-sm-right tabEntry"><i class="far fa-trash-alt fa-2x"></i></small>
                    </label>
                  </span>
                  <span>
                    <label onclick="update(\'scanner\',' . $row['id'] . ')">
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
          <h5 class="modal-title">Update Scanner</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" class="card-c">
          <span id="idInput"></span>
          <input type="text" id="sc-name" name="scname" placeholder="Model Name" class="card-input"><br/>
          <select id="sc-class" name="scclass" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($classes as $row)
            {
                echo '<option value="' . $row['class'] . '">' . $row['class'] . '</option>';
            }
           ?>
          </select><br/>
          <select id="sc-firm" name="scfirm" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($firmware as $row)
            {
                echo '<option value="' . $row['firm'] . '">' . $row['firm'] . '</option>';
            }
            ?>
          </select><br/>

          <div class="left">
          <h6>Flatbed: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scflatbed" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scflatbed" value="false"> No</label><br/>
          <h6>ADF: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scadf" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scadf" value="false"> No</label><br/>           
          <h6>Sheet Feed: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scsheet_feed" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scsheet_feed" value="false"> No</label><br/>
          </div>
          <input type="submit" id="submitScanner" hidden>
        </form>
 
        </div>
        <div class="modal-footer">
          <div id="insertLabel"></div>
          <label for="submitScanner" class="btn btn-primary" tabindex="0">Update</label>
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
