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
    </tr>
  </thead>
  <tbody>
<?php
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
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['type'] . '</td>';
    echo '<td>' . $row['region'] . '</td>';
    echo '</tr>';
}

?>
  </tbody>
</table>


</body>
</div>

</html>