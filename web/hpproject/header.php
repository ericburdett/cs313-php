<head>
  <meta charset="utf-8">
  <title>My Header</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>


<nav style="padding:0px" class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li><a class="nav-link navbar-brand" href="home.php">Dashboard</a></li>
      <li class="dropdown"><a class="nav-link navbar-brand dropdown-toggle" data-toggle="dropdown" href="#">Database<span class="caret"></span></a>
        <ul class="dropdown-menu bg-dark">
          <li><a class="nav-link" href="dbCustomer.php">Customers</a></li>
          <li><a class="nav-link" href="dbDevice.php">Devices</a></li>
          <li><a class="nav-link" href="dbSolution.php">Solutions</a></li>
          <li><a class="nav-link" href="dbEmployee.php">Employees</a></li>
        </ul>
      </li>
      <li><a class="nav-link navbar-brand" href="csv.php">Insert</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-brand navbar-right">
      <li><a class="nav-link" href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<span class="glyphicon glyphicon-log-out"></span>


