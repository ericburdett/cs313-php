<!DOCTYPE html>
<html>
  <head>
    <title>Purchase Review</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style05.css" />
  </head>
  
  <body>
    <header>
      <a href="assign10.html">
        <img src="newJazz.gif" height="80" width="151" style="float:left; padding:0; margin:0;" />
      </a>
      <ul>
        <li>
          <a href="assign10.html">
            <span id="navMen">Home</span>
          </a>
        </li>
        <li>
          <a href="http://www.nba.com/">
            <span id="navMen">NBA.com</span>
          </a>
        </li>
      </ul>
    </header>

    <h1>Is the following information correct?</h1>
    <br />
 

    <div class="fontcolor">
      Name: <?php echo $_POST['first']?>
            <?php echo $_POST['last']?><br /><br />
      Address: <?php echo $_POST['address']?><br /><br />
      Phone: <?php echo $_POST['phone']?><br /><br />
      Credit Card Type: <?php echo $_POST['ccType']?><br /><br />
      Credit Card Number: <?php echo $_POST['ccNumber']?><br /><br />
      
      <?php
            $ccMonth = $_POST['month'];
            if ($ccMonth == 1)
              $ccMonth = "January";
            if ($ccMonth == 2)
              $ccMonth = "February";
            if ($ccMonth == 3)
              $ccMonth = "March";
            if ($ccMonth == 4)
              $ccMonth = "April";
            if ($ccMonth == 5)
              $ccMonth = "May";
            if ($ccMonth == 6)
              $ccMonth = "June";
            if ($ccMonth == 7)
              $ccMonth = "July";
            if ($ccMonth == 8)
              $ccMonth = "August";
            if ($ccMonth == 9)
              $ccMonth = "September";
            if ($ccMonth == 10)
              $ccMonth = "October";
            if ($ccMonth == 11)
              $ccMonth = "November";
            if ($ccMonth == 12)
              $ccMonth = "December";   
      
      echo "Credit Card Expiration: $ccMonth"?>/<?php echo $_POST['year']?><br /><br />
      Items you are purchasing: <br /><?php echo $_POST['items']?><br />
      Total Cost: <?php echo $_POST['cost']?><br /><br />
      <input type="button" id="button" value="Yes, Submit!" onclick="location.href='confirmation.php?success'" />
      <input type="button" id="button" value="No, Cancel!" onclick="location.href='confirmation.php?canceled'" /><br /><br />
    </div>
    
  </body>
</html>