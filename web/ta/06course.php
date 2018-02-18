<?php
require 'dbConnect.php';

$stmt = $db->prepare('SELECT * FROM course');
$stmt->execute();


?>

<h1>Courses</h1>

<?php
  foreach($stmt->fetchAll() AS $row)
  {
      echo '<a href="06notes.php?id=' . $row['id'] . '">' . $row['number'] . ': ' . $row['name'] . '</a><br/>';
  }
?>