<?php
session_start();
?>

<DOCTYPE html>
<head>
  <title>Checkout</title>
  <meta charset="utf-8">
</head>
<body>
<?php
  require 'navbar.php'
?>

<div style="margin:10px">

<form action="confirmation.php" method="POST">
<div class="form-group">
  <label for="usr">Name:</label>
  <input name="name" type="text" class="form-control" id="usr">
</div>
<div class="form-group">
  <label for="comment">Address</label>
  <textarea name="address" class="form-control" rows="5" id="comment"></textarea>
</div>
<button type="submit" class="btn btn-default">Submit</button>
<a href="cart.php"><button type="button" class="btn btn-default">Return to Cart</button></a>
</form>
</div>

</body>

</html>