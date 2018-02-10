<?php
session_start();

if (isset($_SESSION['started'])) {
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>My Header</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">
    <div class="Absolute-Center is-Responsive col-md-4 col-md-offset-4">
      <form action="authenticate.php" method="POST">
        <div class="form-group hp-center">
          <img class="hp-center" src="hp.png" height="160px" width="160px">
        </div>
        <div class="form-group">
          <!--<span class="icon-wrapper"><i class="fas fa-user"></span></i>-->
          <input type="email" placeholder="Email" class="form-control ibox" id="email">
        </div>
        <div class="form-group">
          <!--<i class="fas fa-lock"></i>-->
          <input type="password" placeholder="Password" class="form-control ibox" id="pwd">
        </div>
        <div class="form-group">
          <input type="submit" value="Login" class="btn btn-primary btn-block">
        </div>
        </form>
    </div>
</div>

</body>
</html>