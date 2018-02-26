<html>
<head>
  <title>Dashboard</title>
</head>

<?php
require 'header.php';
?>

<div class="marg">
<body>

<?php
    //Get employee information for logged in employee
    $stmt = $db->prepare('SELECT * FROM employee WHERE id = :id');
    $stmt->bindValue(':id', $_SESSION['employee_id'], PDO::PARAM_INT);
    $stmt->execute();
    $employee = $stmt->fetch();

    //Get Customer count
    $stmt = $db->prepare('SELECT COUNT(*) AS "count"
                          FROM customer c INNER JOIN customer_employee ce
                          ON c.id = ce.customer_id
                          WHERE ce.employee_id = :id');
    $stmt->bindValue(':id',$_SESSION['employee_id'], PDO::PARAM_INT);
    $stmt->execute();
    $cust = $stmt->fetch();

    //Get Devices count
    $stmt = $db->prepare('SELECT COUNT(*) AS "count"
                          FROM customer c INNER JOIN customer_employee ce
                          ON c.id = ce.customer_id INNER JOIN customer_printer cp
                          ON c.id = cp.customer_id
                          WHERE ce.employee_id = :id');
    $stmt->bindValue(':id',$_SESSION['employee_id'], PDO::PARAM_INT);
    $stmt->execute();
    $dev = $stmt->fetch();
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>
        <?php
        echo 'Welcome, ' . $employee['name'] . '!';
        ?>
        </h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">
        Name: <?php echo $employee['name']; ?> <br />
        Email: <?php echo $employee['email']; ?> <br />
        Region: <?php echo $employee['region']; ?> <br />
        Type: <?php echo $employee['type']; ?> <br />
        </p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Customers</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">Customer Count: <?php echo $cust['count']; ?> </p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Devices</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">Device Count: <?php echo $dev['count']; ?> </p>
      </div>
    </div>
  </div>
</div>


</body>
</div>

</html>
