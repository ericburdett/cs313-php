<?php
session_start();

$name = htmlspecialchars($_REQUEST["name"]);
$address = htmlspecialchars($_REQUEST["address"]);

?>

<DOCTYPE html>
<head>
  <title>Confirmation</title>
  <meta charset="utf-8">
</head>
<body>
<?php
  require 'navbar.php'
?>

<div style="text-align:center;">
  <h1>Thank you for your business!</h1>
  <h3>Below is your order information.</h3>
</div>


<div style="margin:10px">
<h5>Name:&nbsp;<?php echo $name ?></h5>
<h5>Address:&nbsp;<?php echo $address ?></h5>
<h5>Items Purchased:</h5>
<?php
  if ($_SESSION["gobert"] == true) {
    echo "<h5>&bull;&nbspGobert Jersey</h5>";
  }
  if ($_SESSION["favors"] == true) {
    echo "<h5>&bull;&nbspFavors Jersey</h5>";
  }
  if ($_SESSION["mitchell"] == true) {
    echo "<h5>&bull;&nbspMitchell Jersey</h5>";
  }
  if ($_SESSION["rubio"] == true) {
    echo "<h5>&bull;&nbspRubio Jersey</h5>";
  } 
  if ($_SESSION["stockton"] == true) {
    echo "<h5>&bull;&nbspStockton Jersey</h5>";
  }   
  if ($_SESSION["malone"] == true) {
    echo "<h5>&bull;&nbspMalone Jersey</h5>";
  }
  if ($_SESSION["hoodie"] == true) {
    echo "<h5>&bull;&nbspJazz Hoodie</h5>";
  }
  if ($_SESSION["shirt"] == true) {
    echo "<h5>&bull;&nbspJazz Shirt</h5>";
  }
  if ($_SESSION["backpack"] == true) {
    echo "<h5>&bull;&nbspJazz Backpack</h5>";
  }
  if ($_SESSION["lanyard"] == true) {
    echo "<h5>&bull;&nbspJazz Lanyard</h5>";
  }
  if ($_SESSION["mug"] == true) {
    echo "<h5>&bull;&nbspJazz Mug</h5>";
  }
  if ($_SESSION["spinner"] == true) {
    echo "<h5>&bull;&nbspJazz Spinner</h5>";
  }
  if ($_SESSION["flag"] == true) {
    echo "<h5>&bull;&nbspJazz Flag</h5>";
  }
  if ($_SESSION["socks"] == true) {
    echo "<h5>&bull;&nbspJazz Socks</h5>";
  }
  if ($_SESSION["sandles"] == true) {
    echo "<h5>&bull;&nbspJazz Sandles</h5>";
  }

  session_unset();
  session_destroy();
?>
</div>

</body>

</html>