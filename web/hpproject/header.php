<?php
session_start();

if (!$_SESSION['started']) {
  header('Location: index.php');
}

require 'dbConnect.php';

?>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <link rel="stylesheet" href="style.css"> 
</head>

<?php
$file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
?>

<nav style="padding:0px" class="navbar navbar-expand-sm bg-dark navbar-dark navbar-fixed-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li><a class="nav-link navbar-brand <?php if ($file == 'home') {echo 'active';} ?>" href="home.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="dropdown"><a class="nav-link navbar-brand dropdown-toggle <?php if ($file != 'home' && $file != 'csv' && $file != 'insert') {echo 'active';}  ?>" data-toggle="dropdown" href="#"><i class="fas fa-database"></i> Database<span class="caret"></span></a>
        <ul class="dropdown-menu bg-dark">
          <li><a class="nav-link" href="dbCustomer.php">Customers</a></li>
          <li><a class="nav-link" href="dbPrinter.php">Printers</a></li>
          <li><a class="nav-link" href="dbScanner.php">Scanners</a></li>
          <li><a class="nav-link" href="dbSolution.php">Solutions</a></li>
          <li><a class="nav-link" href="dbEmployee.php">Employees</a></li>
        </ul>
      </li>
      <li class="dropdown"><a class="nav-link navbar-brand dropdown-toggle <?php if ($file == 'csv' || $file == 'insert') {echo 'active';} ?>" data-toggle="dropdown" href="#"><i class="fas fa-plus"></i> Insert</a><span class="caret"></span></a>
        <ul class="dropdown-menu bg-dark">
          <li><a class="nav-link" href="insert.php">Manual</a></li>
          <li><a class="nav-link" href="csv.php">With CSV</a></li>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-brand navbar-right">
      <li><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

    </ul>
  </div>
</nav>