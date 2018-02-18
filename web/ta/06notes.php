<?php
  require 'dbConnect.php';

  if (isset($_POST['content']))
  {
      $insert = $db->prepare('INSERT INTO note VALUES
                              (
                                  DEFAULT,
                                  :id,
                                  :content,
                                  current_date
                              )');
      $insert->bindValue(':content',$_POST['content'],PDO::PARAM_STR);
      $insert->bindValue(':id',$_POST['id'],PDO::PARAM_STR);
      $insert->execute();
  }

  if (isset($_GET["id"]))
  {
      $stmt = $db->prepare('SELECT *
                            FROM note
                            WHERE course_id = :id');
      $stmt->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
      $stmt->execute();
  }
?>

<body>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Date</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach($stmt->fetchAll() AS $row)
        {
            echo '<tr>
                    <td>' . $row['date'] . '</td>
                    <td>' . $row['content'] . '</td>
                  </tr>';
        }
      ?>
    </tbody>
  </table><br/><br/>

  <h4>Insert New Note</h4>
  <form action="#" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <textarea name="content"></textarea><br/>
    <input type="submit" value="Insert">
  </form>



</body>