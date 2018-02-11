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


    echo '<div id="accordian">
            <div class="card bg-dark marg">
              <div class="card-header">
                <a class="card-link tabhead" data-toggle="collapse" data-parent="#accordian" href="#collapse' . $counter . '">'
                . $row['name'] . '
                </a>
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

<!--
  </tbody>
</table>
-->

</body>
</div>

</html>
