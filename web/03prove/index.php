<?php
session_start();
?>

<DOCTYPE html>
<head>
  <title>Browse Items</title>
  <meta charset="utf-8">
</head>
<body>
<?php
  require 'navbar.php'
?>

<h1 style="text-align:center;">Click on any item to add it to your shopping cart.</h1>

<?php
if (!isset($_SESSION["started"])) {

  $_SESSION["gobert"] = false;
  $_SESSION["favors"] = false;
  $_SESSION["mitchell"] = false;
  $_SESSION["rubio"] = false;
  $_SESSION["stockton"] = false;
  $_SESSION["malone"] = false;
  $_SESSION["hoodie"] = false;
  $_SESSION["shirt"] = false;
  $_SESSION["backpack"] = false; 
  $_SESSION["lanyard"] = false;
  $_SESSION["mug"] = false;
  $_SESSION["spinner"] = false;
  $_SESSION["flag"] = false;
  $_SESSION["socks"] = false;
  $_SESSION["sandles"] = false;
}

$_SESSION["started"] = true;

if (isset($_REQUEST["gobert"])) {
  echo "<h6>Gobert Jersey Added to Cart.</h6>";
  $_SESSION["gobert"] = true;
}
if (isset($_REQUEST["favors"])) {
  echo "<h6>Favors Jersey Added to Cart.</h6>";
  $_SESSION["favors"] = true;
}
if (isset($_REQUEST["mitchell"])) {
   echo "<h6>Mitchell Jersey Added to Cart.</h6>";
 $_SESSION["mitchell"] = true;
}
if (isset($_REQUEST["rubio"])) {
   echo "<h6>Rubio Jersey Added to Cart.</h6>";
 $_SESSION["rubio"] = true;
}
if (isset($_REQUEST["stockton"])) {
   echo "<h6>Stockton Jersey Added to Cart.</h6>";
 $_SESSION["stockton"] = true;
}
if (isset($_REQUEST["malone"])) {
   echo "<h6>Malone Jersey Added to Cart.</h6>";
 $_SESSION["malone"] = true;
}
if (isset($_REQUEST["hoodie"])) {
   echo "<h6>Hoodie Added to Cart.</h6>";
 $_SESSION["hoodie"] = true;
}
if (isset($_REQUEST["shirt"])) {
   echo "<h6>Jazz Shirt Added to Cart.</h6>";
 $_SESSION["shirt"] = true;
}
if (isset($_REQUEST["backpack"])) {
   echo "<h6>Jazz Backpack Added to Cart.</h6>";
 $_SESSION["backpack"] = true;
}
if (isset($_REQUEST["lanyard"])) {
   echo "<h6>Jazz Lanyard Added to Cart.</h6>";
 $_SESSION["lanyard"] = true;
}
if (isset($_REQUEST["mug"])) {
   echo "<h6>Jazz Mug Added to Cart.</h6>";
 $_SESSION["mug"] = true;
}
if (isset($_REQUEST["spinner"])) {
   echo "<h6>Jazz Spinner Added to Cart.</h6>";
 $_SESSION["spinner"] = true;
}
if (isset($_REQUEST["flag"])) {
   echo "<h6>Jazz Flag Added to Cart.</h6>";
 $_SESSION["flag"] = true;
}
if (isset($_REQUEST["socks"])) {
   echo "<h6>Jazz Socks Added to Cart.</h6>";
 $_SESSION["socks"] = true;
}
if (isset($_REQUEST["sandles"])) {
   echo "<h6>Jazz Sandles Added to Cart.</h6>";
 $_SESSION["sandles"] = true;
}
?>

<div class="row">
  <div class="col-md-3">
    <form action = "#" method = "POST">
      <input type="text" name="gobert" hidden>
      <input type="image" src="images/jersey-gobert.png">
      <p>Rudy Gobert Jersey</p>
    </form>
    <br /><br /><br /><br />
      <form action = "#" method = "POST">
        <input type="text" name="stockton" hidden>
        <input type="image" src="images/jersey-stockton.jpg">
        <p>John Stockton Jersey</p>
      </form>
    <br /><br /><br /><br />
      <form action = "#" method = "POST">
        <input type="text" name="backpack" hidden>
        <input name="backpack" type="image" src="images/backpack.png">
        <p>Jazz Backpack</p>
      </form>
    <br /><br /><br /><br />
    <form action ="#" method = "POST">
      <input type="text" name="flag" hidden>
      <input type="image" src="images/flag.png">
      <p>Jazz Flag</p>
    </form>
  </div>
  <div class="col-md-3">
    <form action = "#" method = "POST">
      <input type="text" name="favors" hidden>
      <input type="image" src="images/jersey-favors.png">
      <p>Derrick Favors Jersey</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="malone" hidden>
      <input type="image" src="images/jersey-malone.jpg">
      <p>Karl Malone Jersey</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="lanyard" hidden>
      <input type="image" src="images/lanyard.png">
      <p>Jazz Lanyard</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="socks" hidden>
      <input type="image" src="images/socks.png">
      <p>Jazz Socks</p>
    </form>
  </div>
  <div class="col-md-3">
    <form action = "#" method = "POST">
      <input type="text" name="mitchell" hidden>
      <input type="image" src="images/jersey-mitchell.jpg">
      <p>Donovan Mitchell Jersey</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="hoodie" hidden>
      <input type="image" src="images/hoodie.png">
      <p>Jazz Hoodie</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="mug" hidden>
      <input type="image" src="images/mug.png">
      <p>Jazz Mug</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="sandles" hidden>
      <input type="image" src="images/sandles.png">
      <p>Jazz Sandles</p>
    </form>
  </div>
  <div class="col-md-3">
    <form action = "#" method = "POST">
      <input type="text" name="rubio" hidden>
      <input type="image" src="images/jersey-rubio.jpg">
      <p>Ricky Rubio Jersey</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="shirt" hidden>
      <input type="image" src="images/shirt.png">
      <p>Jazz Shirt</p>
    </form>
    <br /><br /><br /><br />
    <form action = "#" method = "POST">
      <input type="text" name="spinner" hidden>
      <input type="image" src="images/spinner.png">
      <p>Jazz Spinner</p>
    </form>
  </div>
</div>

</body>

</html>