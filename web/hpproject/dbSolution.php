<?php
session_start();
?>
<html>
<head>
  <title>Solutions</title>
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
<h2>Solutions</h2>
<form action="#" method="GET">
  <input type="text" name="value" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  <select class="form-control selectWidth" name="column">
    <option value="name" <?php if ($_GET['column'] == 'name') { echo 'selected="selected" ';} ?>>Name</option>
    <option value="type" <?php if ($_GET['column'] == 'type') { echo 'selected="selected" ';} ?>>Type</option>
  </select><br />
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbSolution.php" class="btn btn-primary btn-md" role="button">Reset</a>
</form>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php
//Delete
if (isset($_POST['solution'])) {
    $delete = $db->prepare('DELETE FROM solution WHERE id = :id');
    $delete->bindValue(':id',$_POST['solution'],PDO::PARAM_INT);
    delete($delete);
}

//Update
if (isset($_POST['id'])) {
  $update = $db->prepare('UPDATE solution SET
                          name = :name,
                          type = :type
                          WHERE id = :id');
  $update->bindValue(':id',emptyToNull($_POST['id']),PDO::PARAM_INT);
  $update->bindValue(':name',emptyToNull($_POST['soname']), PDO::PARAM_STR);
  $update->bindValue(':type',emptyToNull($_POST['sotype']), PDO::PARAM_STR);

  update($update);
}

//Query
$solutionType = $db->prepare('SELECT unnest(enum_range(NULL::solutionType)) AS type');
$solutionType->execute();

$stmt = $db->prepare('SELECT * FROM solution ORDER BY name');
$myVal = $_GET['value'];
$myCol = $_GET['column'];

if (isset($myCol) && !empty($myCol)) {
    if ($myCol == 'name') {
        $stmt = $db->prepare("SELECT * FROM solution WHERE LOWER($myCol) LIKE LOWER(:val) ORDER BY name");
        $stmt->bindValue(':val', '%' . $myVal . '%', PDO::PARAM_STR);
    }
    else {
        $stmt = $db->prepare("SELECT * FROM solution WHERE $myCol = :val ORDER BY name");
        $stmt->bindValue(':val', $myVal, PDO::PARAM_STR);
    }
}

$stmt->execute();
//For Testing

foreach($stmt->fetchAll() as $row)
{
    echo '<form action="#" method="POST">
            <input type="text" value="' . $row['id'] . '" name="solution" hidden>
            <input type="submit" id="solution_s' . $row['id'] . '" hidden>
          </form>';

    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['type'] . '</td>';
    echo '<td>
                <div class="nowrap">
                  <span>
                    <label onclick="confirmation(\'solution\',' . $row['id'] . ')">
                      <small class="float-sm-right tabEntry"><i class="far fa-trash-alt fa-2x"></i></small>
                    </label>
                  </span>
                  <span>
                    <label onclick="update(\'solution\',' . $row['id'] . ')">
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
          <h5 class="modal-title">Update Solution</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" class="card-c">
          <span id="idInput"></span>
          <input type="text" id="so-name" name="soname" placeholder="Name" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['soname'] . '"'; } ?>><br/>
          <select name="sotype" id="so-type" class="card-input">
            <?php
            //Get all options from employeeType enum and place in select options
            foreach($solutionType->fetchAll() as $row)
            {
                echo '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
            }
            ?>
          </select><br/>
          <input type="submit" id="submitSolution" hidden>
        </form>
        </div>
        <div class="modal-footer">
          <div id="insertLabel"></div>
          <label for="submitSolution" class="btn btn-primary" tabindex="0">Update</label>
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
