<?php
session_start();
?>
<html>
<head>
  <title>Insert with CSV</title>
</head>

<?php
require 'header.php';
?>

<div class="marg">
<body>
<h2>Coming Soon!</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <h5>Select CSV to upload:</h5>
    <input type="file" name="fileToUpload" id="fileToUpload" class="btnspace"><br/>
    <input type="submit" value="Upload CSV" name="submit" class="btnspace">
</form>
</body>
</div>

</html>