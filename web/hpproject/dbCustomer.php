<?php
session_start();
?>
<html>
<head>
</head>

<?php
require 'header.php';
require 'functions.php';
//require 'dbHeader.php';

if (isset($_POST['rowConfId'])) {
  echo '<form action="#" method="POST">
          <input type="text" name="rowId" value="' . $_POST['rowConfId'] . '">
          <input type="submit"  id="submitDelete">
        </form>';

  echo '<script>
          $(window).on("load", function(){ $("#confirmDelete").modal("show"); });
        </script>';
}


if (isset($_POST['rowId'])) {
  //Call function in "functions.php" that will delete all rows with reference to this customer
  //Return of 0 indicates failure, 1 indicates success
  if (deleteCustomer($db,$_POST['rowId'])) {
    //Success
    echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
    $_SESSION['dbFail'] = true;
  }
  else {
    //Error
    echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
    $_SESSION['dbFail'] = true;
  }
}

?>

<div class="marg">
<body>

<h2>Customers</h2>
<form action="#" method="GET">
<div class="input-group">
  <span class="input-group-btn">
  <input type="text" name="value" placeholder="Customer Name" size="50" maxlength="50" class="textHeight" <?php if (isset($_GET['value'])) { echo 'value="' . $_GET['value'] . '"';} ?>>
  </span>&nbsp;
<!--  <select class="form-control selectWidth" name="column">
    <option value="name" <?php if ($_GET['column'] == 'name') { echo 'selected="selected" ';} ?>>Name</option>
    <option value="phone" <?php if ($_GET['column'] == 'phone') { echo 'selected="selected" ';} ?>>Phone</option>
    <option value="region" <?php if ($_GET['column'] == 'region') { echo 'selected="selected" ';} ?>>Region</option>
    <option value="type" <?php if ($_GET['column'] == 'type') { echo 'selected="selected" ';} ?>>Type</option>
    <option value="notes" <?php if ($_GET['column'] == 'notes') { echo 'selected="selected" ';} ?>>Notes</option>
  </select><br />-->
  <input type="submit" class="btn btn-primary btn-md">
  <a href="dbCustomer.php" class="btn btn-primary btn-md" role="button">Reset</a>
</div>
</form>


<!--
<table class="table table-dark table-hover">
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
-->
<?php

$stmt = $db->prepare('SELECT * FROM customer ORDER BY name');
$myVal = $_GET['value'];
$myCol = 'name';//$_GET['column'];

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

$counter = 0;

foreach($stmt->fetchAll() as $row)
{
    //Query for Customer Contacts
    $stmt0 = $db->prepare('SELECT ce.name AS "name", ce.title AS "title", ce.email AS "email", ce.business_phone AS "business", ce.mobile_phone AS "mobile", ce.main_contact AS "main", ce.notes AS "notes"
                           FROM customer c INNER JOIN customer_contact ce
                           ON c.id = ce.customer_id
                           WHERE c.id = :id');
    $stmt0->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt0->execute();

    //Query for Employees
    $stmt2 = $db->prepare('SELECT e.name AS "name", e.email AS "email", e.type AS "type"
                           FROM customer c INNER JOIN customer_employee ce
                           ON c.id = ce.customer_id INNER JOIN employee e
                           ON ce.employee_id = e.id
                           WHERE c.id = :id');
    $stmt2->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt2->execute();

    //Query for Printers
    $stmt3 = $db->prepare('SELECT p.model_name AS "name", cp.qty_in_fleet AS "qty", cp.fs4 AS "fs4", cp.notes as "notes"
                           FROM customer c INNER JOIN customer_printer cp
                           ON c.id = cp.customer_id INNER JOIN printer p
                           ON p.id = cp.printer_id
                           WHERE c.id = :id');
    $stmt3->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt3->execute();

    //Query for Scanners
    $stmt4 = $db->prepare('SELECT s.model_name AS "name", cs.qty_in_fleet AS "qty", cs.fs4 AS "fs4", cs.notes AS "notes"
                           FROM customer c INNER JOIN customer_scanner cs
                           ON c.id = cs.customer_id INNER JOIN scanner s
                           ON s.id = cs.scanner_id
                           WHERE c.id = :id');
    $stmt4->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt4->execute();

    //Query for Solutions
    $stmt5 = $db->prepare('SELECT s.name AS "name", cs.version AS "version", cs.qty_licenses AS "qty", cs.notes AS "notes"
                           FROM customer c INNER JOIN customer_solution cs
                           ON c.id = cs.customer_id INNER JOIN solution s
                           ON s.id = cs.solution_id
                           WHERE c.id = :id');
    $stmt5->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt5->execute();

    //Query for Locations
    $stmt6 = $db->prepare('SELECT l.address AS "address", l.city AS "city", l.state AS "state", l.zip AS "zip", l.country AS "country"
                           FROM customer c INNER JOIN customer_location cl
                           ON c.id = cl.customer_id INNER JOIN location l
                           ON l.id = cl.location_id 
                           WHERE c.id = :id');
    $stmt6->bindValue(':id',$row['id'], PDO::PARAM_INT);
    $stmt6->execute();


    echo '<div id="accordian">
            <div class="card bg-dark marg">
              <div class="card-header">
                <a class="card-link tabhead" data-toggle="collapse" data-parent="#accordian" href="#collapse' . $counter . '">'
                . $row['name'] . '
                </a>
                <form style="display:inline" action="#" method="POST">
                  <input type="text" hidden name="rowConfId" value="' . $row['id'] . '">
                  <input type="submit" hidden id="confSubmit' . $counter . '">
                  <label style="display:inline" for="confSubmit' . $counter . '" tabindex="0">
                    <small class="float-sm-right tabhead"><i class="far fa-trash-alt fa-2x"></i></small>
                  </label>
                </form>
              </div>
            </div>
          </div>';

    echo '<div id ="collapse' . $counter++ . '" class ="collapse">
            <div class="card-body">
              <h5>Customer Info:</h5>
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Phone</th>
                    <td>' . $row['phone'] . '</td>
                  </tr>
                  <tr>
                    <th>Region</th>
                    <td>' . $row['region'] . '</td>
                  </tr>
                  <tr>
                    <th>Type</th>
                    <td>' . $row['type'] . '</td>
                  </tr>
                  <tr>
                    <th>Notes</th>
                    <td>' . $row['notes'] . '</td>
                  </tr>
                </tbody>
              </table>
              <h5>Contacts:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Email</th>
                    <th>Business Phone</th>
                    <th>Mobile Phone</th>
                    <th>Main Contact</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>';

//                $add_counter = 1;
//                Possibly change format for address
                foreach($stmt0->fetchAll() AS $row0)
                {
                    $main = 'No';
                    if ($row0['main']) {
                        $main = 'Yes';
                    }
                    echo '<tr>
                            <td>' . $row0['name'] . '</td>
                            <td>' . $row0['title'] . '</td>
                            <td>' . $row0['email'] . '</td>
                            <td>' . $row0['business'] . '</td>
                            <td>' . $row0['mobile'] . '</td>
                            <td>' . $main . '</td>
                            <td>' . $row0['notes'] . '</td>
                          </tr>';
                }

    echo       '</tbody>
              </table>
              <h5>Locations:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Country</th>
                  </tr>
                </thead>
                <tbody>';

                foreach($stmt6->fetchAll() AS $row6)
                {
                    echo '<tr>
                            <td>' . $row6['address'] . '</td>
                            <td>' . $row6['city'] . '</td>
                            <td>' . $row6['state'] . '</td>
                            <td>' . $row6['zip'] . '</td>
                            <td>' . $row6['country'] . '</td>
                          </tr>';
                }


    echo       '</tbody>
              </table>
              
              <h5>Employees:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>';

                foreach ($stmt2->fetchAll() AS $row2)
                {
                    echo '<tr>
                            <td>' . $row2['name'] . '</td>
                            <td>' . $row2['type'] . '</td>
                            <td>' . $row2['email'] . '</td>
                          </tr>';
                }
                
    echo       '</tbody>
              </table>
              <h5>Printers:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>FS3/FS4</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>';

                foreach($stmt3->fetchAll() AS $row3)
                {
                    $fs = 'FS3';
                    if ($row3['fs4']) {
                        $fs = 'FS4';
                    }
                    

                    echo '<tr>
                            <td>' . $row3['name'] . '</td>
                            <td>' . $row3['qty'] . '</td>
                            <td>' . $fs . '</td>
                            <td>' . $row3['notes'] . '</td>
                          </tr>';
                }
                
    echo        '</tbody>
              </table>
              <h5>Scanners:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>FS3/FS4</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>';

                 foreach($stmt4->fetchAll() AS $row4)
                {
                    $fs = 'FS3';
                    if ($row4['fs4']) {
                        $fs = 'FS4';
                    }

                    echo '<tr>
                            <td>' . $row4['name'] . '</td>
                            <td>' . $row4['qty'] . '</td>
                            <td>' . $fs . '</td>
                            <td>' . $row4['notes'] . '</td>
                          </tr>';
                }

    echo       '</tbody>
              </table>
              <h5>Solutions:</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Quantity of Licenses</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>';
                
                foreach($stmt5->fetchAll() AS $row5)
                {
                    echo '<tr>
                            <td>' . $row5['name'] . '</td>
                            <td>' . $row5['version'] . '</td>
                            <td>' . $row5['qty'] . '</td>
                            <td>' . $row5['notes'] . '</td>
                          </tr>';
                }

    echo       '</tbody>
              </table>
            </div>
          </div>';

    /*
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '<td>' . $row['region'] . '</td>';
    echo '<td>' . $row['type'] . '</td>';
    echo '<td>' . $row['notes'] . '</td>';
    echo '</tr>';
    */


    /*
    echo '<div id="collapse' . $counter++ . '" class="collapse">';
    echo 'Collapsed Data!';
    echo '</div>';
    */   
}
?>




  <!-- Deletion Confirm Modal -->
  <div class="modal fade" id="confirmDelete" role="dialog">
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
            <div id="custName"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitDelete" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
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
          <p>The row was successfully deleted.</p>
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
          <p>There was an error deleting the row.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>




</body>
</div>

</html>
