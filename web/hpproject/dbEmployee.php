<?php
session_start();
?>
<html>
<head>
  <title>Employees</title>
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
?>

<div class="marg">
<body>

<h2>Employees</h2>
<form action="#" method="GET">
  <input type="text" name="value" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  <select class="form-control selectWidth" name="column">
    <option value="name" <?php if ($_GET['column'] == 'name') { echo 'selected="selected" ';} ?>>Name</option>
    <option value="email" <?php if ($_GET['column'] == 'email') { echo 'selected="selected" ';} ?>>Email</option>
    <option value="type" <?php if ($_GET['column'] == 'type') { echo 'selected="selected" ';} ?>>Type</option>
    <option value="region" <?php if ($_GET['column'] == 'region') { echo 'selected="selected" ';} ?>>Region</option>
  </select><br />
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbEmployee.php" class="btn btn-primary btn-md" role="button">Reset</a>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Type</th>
      <th>Region</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php
//Delete
if (isset($_POST['employee'])) {
    $delete = $db->prepare('DELETE FROM employee WHERE id = :id');
    $delete->bindValue(':id',$_POST['employee'],PDO::PARAM_INT);
    delete($delete);
}

//Update
if (isset($_POST['id'])) {
  $update = $db->prepare('UPDATE employee SET
                          name = :name,
                          email = :email,
                          type = :type,
                          region = :region
                          WHERE id = :id');
  $update->bindValue(':id',emptyToNull($_POST['id']),PDO::PARAM_INT);
  $update->bindValue(':name',emptyToNull($_POST['ename']),PDO::PARAM_STR);
  $update->bindValue(':email',emptyToNull($_POST['eemail']),PDO::PARAM_STR);
  $update->bindValue(':type',emptyToNull($_POST['etype']),PDO::PARAM_STR);
  $update->bindValue(':region',emptyToNull($_POST['eregion']),PDO::PARAM_STR);

  update($update);
}

//Query
$custRegion = $db->prepare('SELECT unnest(enum_range(NULL::regions)) AS region');
$custRegion->execute();
$regions = $custRegion->fetchAll();

$empType = $db->prepare('SELECT unnest(enum_range(NULL::employeeType)) AS name');
$empType->execute();

$stmt = $db->prepare('SELECT * FROM employee ORDER BY name');
$myVal = $_GET['value'];
$myCol = $_GET['column'];

if (isset($myCol) && !empty($myCol)) {
    if ($myCol == 'name' || $myCol == 'email') {
        $stmt = $db->prepare("SELECT * FROM employee WHERE LOWER($myCol) LIKE LOWER(:val) ORDER BY name");
        $stmt->bindValue(':val', '%' . $myVal . '%', PDO::PARAM_STR);
    }
    else {
        $stmt = $db->prepare("SELECT * FROM employee WHERE $myCol = :val ORDER BY name");
        $stmt->bindValue(':val', $myVal, PDO::PARAM_STR);
    }
}

$stmt->execute();
//For Testing

foreach($stmt->fetchAll() as $row)
{
    echo '<form action="#" method="POST">
            <input type="text" value="' . $row['id'] . '" name="employee" hidden>
            <input type="submit" id="employee_s' . $row['id'] . '" hidden>
          </form>';

    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['type'] . '</td>';
    echo '<td>' . $row['region'] . '</td>';
    echo '<td>
                <div class="nowrap">
                  <span>
                    <label onclick="confirmation(\'employee\',' . $row['id'] . ')">
                      <small class="float-sm-right tabEntry"><i class="far fa-trash-alt fa-2x"></i></small>
                    </label>
                  </span>
                  <span>
                    <label onclick="update(\'employee\',' . $row['id'] . ')">
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
          <h5 class="modal-title">Update Employee</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" class="card-c">
          <span id="idInput"></span>
          <input type="text" id="e-name" name="ename" placeholder="Name" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['ename'] . '"'; } ?>><br/>
          <input type="text" id="e-email" name="eemail" placeholder="Email" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['eemail'] . '"'; } ?>><br/>
          <select id="e-region" name="eregion" class="card-input">
            <?php
            foreach($regions as $row)
            {
              //Keep selected element on insert error instead of resetting the form
              $selected = '';
              if ($_POST['eregion'] == $row['region'] && $_SESSION['dbFail']) {
                $selected = ' selected ';
              }
              echo '<option value="' . $row['region'] . '"' . $selected . '>' . $row['region'] . '</option>';
            }
            ?>
          </select>
          <select name="etype" id="e-type" class="card-input">
<!--            <option disabled selected hidden>Employee Type</option> -->
            <?php
            //Get all options from employeeType enum and place in select options
            foreach($empType as $row)
            {
                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <input type="submit" id="submitEmployee" hidden>
        </form>
 
        </div>
        <div class="modal-footer">
          <div id="insertLabel"></div>
          <label for="submitEmployee" class="btn btn-primary" tabindex="0">Update</label>
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