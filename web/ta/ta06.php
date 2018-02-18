<head>
  <meta charset="utf-8">
  <title>My Header</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>

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


<h1>Insert Scripture</h1>

<form action="#" method="POST">
  Book:<br/>
  <input type="text" name="book"><br/>
  Chapter:<br/>
  <input type="text" name="chapter"><br/>
  Verse:<br/>
  <input type="text" name="verse"><br/>
  Content:<br/>
  <textarea name="content"></textarea><br/>
  <?php
    $stmt = $db->prepare('SELECT name FROM topics');
    $stmt->execute();

    foreach($stmt->fetchAll() AS $row) {
        echo '<input type="checkbox" name="check_' . $row['name'] . '"> ' . $row['name'] . '<br/>';
    }
  ?>
  <input type="submit">

</form>
<br/><br/>


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
  
  if(isset($_POST['book'])) {
    $stmt2 = $db->prepare('INSERT INTO scriptures VALUES
                           (
                              DEFAULT,
                              :book,
                              :chapter,
                              :verse
                              :content
                           )');
    $stmt2->bindValue(':book',$_POST['book'],PDO::PARAM_STR);
    $stmt2->bindValue(':chapter',$_POST['chapter'],PDO::PARAM_STR);
    $stmt2->bindValue(':verse',$_POST['verse'],PDO::PARAM_STR);
    $stmt2->bindValue(':content',$_POST['content'],PDO::PARAM_STR);
    
    $stmt2->execute();

    foreach($stmt->fetchAll() AS $row)
    {
        if(isset($_POST['check_' . $row['name']]))
        {
            $lastId = $db->lastInsertId('scriptures_id_seq');

            $stmt4 = $db->prepare('INSERT INTO scriptures_topics VALUES
                          (
                             DEFAULT,
                             :lastId,
                             (SELECT id FROM topics WHERE name = :topic)
                          )
                          ');
            $stmt4->bindValue(':lastId',$lastId, PDO::PARAM_INT);
            $stmt4->bindValue(':topic');
        }
    }

    $stmt3 = $db->prepare('SELECT * FROM scriptures');
    $stmt3->execute();

    foreach($stmt3->fetchAll() AS $row)
    {
        echo '<tr>
                <td>' . $row['book'] . '</td>
                <td>' . $row['chapter'] . '</td>
                <td>' . $row['verse'] . '</td>
                <td>' . $row['content'] . '</td>
              </tr>';
    }
  }
?>
  </tbody>
</table>