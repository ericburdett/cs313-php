<head>
  <meta charset="utf-8">
  <title>My Header</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>

<h1>Scriptures Resources</h1>

<?php

try
{
    $dbURL = getenv('DATABASE_URL');

    if (empty($dbURL)) {
        $user = 'ta';
        $password = 'teamactivity';
        $db = new PDO('pgsql:host=127.0.0.1;dbname=ta05',$user,$password);
    }
    else {
        $dbopts = parse_url($dbURL);
    
        $dbHost = $dbopts["host"];
        $dbPort = $dbopts["port"];
        $dbUser = $dbopts["user"];
        $dbPassword = $dbopts["pass"];
        $dbName = ltrim($dbopts["path"],'/');

        $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    }
}
catch (PDOException $ex)
{
    echo 'Error!: ' . $ex->getMessage();
    die();
}

?>

<form action="#" method="POST">
  <input type="text" name="bookName">
  <input type="submit">
</form>


<table class="table table-striped">
  <thead>
    <tr>
      <th>Book</th>
      <th>Chapter</th>
      <th>Verse</th>
      <th>Content</th>
    </tr>
  </thead>
  <tbody>
<?php

$whereClause = '';

$myQuery = 'SELECT * FROM scriptures';

//Look at PDO Bind Value example!

if (isset($_POST['bookName'])) {
    $myQuery .= ' WHERE book LIKE \'' . $_POST['bookName'] . '%\'';
}

foreach($db->query($myQuery) as $row)
{
    echo '<tr>';
    echo '<td>' . $row['book'] . '</td>';
    echo '<td>' . $row['chapter'] . '</td>';
    echo '<td>' . $row['verse'] . '</td>';
    echo '<td>' . $row['content'] . '</td>';
    echo '</tr>';
}
?>
  </tbody>
</table>


