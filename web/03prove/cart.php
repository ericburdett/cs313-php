<?php
session_start();

if (isset($_REQUEST["gobert"])) {
  $_SESSION["gobert"] = false;
}
if (isset($_REQUEST["favors"])) {
  $_SESSION["favors"] = false;
}
if (isset($_REQUEST["mitchell"])) {
  $_SESSION["mitchell"] = false;
}
if (isset($_REQUEST["rubio"])) {
  $_SESSION["rubio"] = false;
}
if (isset($_REQUEST["stockton"])) {
  $_SESSION["stockton"] = false;
}
if (isset($_REQUEST["malone"])) {
  $_SESSION["malone"] = false;
}
if (isset($_REQUEST["hoodie"])) {
  $_SESSION["hoodie"] = false;
}
if (isset($_REQUEST["shirt"])) {
  $_SESSION["shirt"] = false;
}
if (isset($_REQUEST["backpack"])) {
  $_SESSION["backpack"] = false;
}
if (isset($_REQUEST["lanyard"])) {
  $_SESSION["lanyard"] = false;
}
if (isset($_REQUEST["mug"])) {
  $_SESSION["mug"] = false;
}
if (isset($_REQUEST["spinner"])) {
  $_SESSION["spinner"] = false;
}
if (isset($_REQUEST["flag"])) {
  $_SESSION["flag"] = false;
}
if (isset($_REQUEST["socks"])) {
  $_SESSION["socks"] = false;
}
if (isset($_REQUEST["sandles"])) {
  $_SESSION["sandles"] = false;
}


?>

<DOCTYPE html>
<head>
  <title>Shopping Cart</title>
  <meta charset="utf-8">
</head>
<?php
  require 'navbar.php'
?>
<body>

<div style="margin-left: 20px; margin-top:10px; margin-right:20px;">
<?php
  if ($_SESSION["gobert"] == true) {
    echo '<div class="row">';
    echo '<h2>Gobert Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="gobert" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["favors"] == true) {
    echo '<div class="row">';
    echo '<h2>Favors Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="favors" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["mitchell"] == true) {
    echo '<div class="row">';
    echo '<h2>Mitchell Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="mitchell" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["rubio"] == true) {
    echo '<div class="row">';
    echo '<h2>Rubio Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="rubio" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["stockton"] == true) {
    echo '<div class="row">';
    echo '<h2>Stockton Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="stockton" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["malone"] == true) {
    echo '<div class="row">';
    echo '<h2>Malone Jersey</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="malone" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["hoodie"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Hoodie</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="hoodie" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["shirt"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Shirt</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="shirt" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["backpack"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Backpack</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="backpack" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["lanyard"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Lanyard</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="lanyard" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["mug"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Mug</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="mug" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["spinner"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Spinner</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="spinner" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["flag"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Flag</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="flag" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["socks"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Socks</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="socks" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
  if ($_SESSION["sandles"] == true) {
    echo '<div class="row">';
    echo '<h2>Jazz Sandles</h2>';
    echo '<form action = "#" method = "POST">
            <input type="text" name="sandles" hidden>
            <input type="image" src="images/remove.png" style="height:30px; width:30px;">
          </form></div>';
  }
?>

<div class="row">
  <a href="checkout.php"><button type="button" class="btn btn-default">Checkout</button></a>
</div>


</div>
</body>

</html>