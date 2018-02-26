<?php

//Turn any empty strings into NULL values. Useful for database entry.
//We don't want any empty strings inside the database.
function emptyToNull($string) {
    if (is_string($string) && strlen($string) == 0) {
        $string = NULL;
    }
    return $string;
}

//Handles insertions on Heroku and Locally. Due to a quirk with Heroku, the exception
//handling must be present or else a fatal error will cause the page to stop rendering
//upon a failed database query.
function insert($insert) {
    try {
      if (!$insert->execute())
      {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
      }
      else
      {
        echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
        $_SESSION['dbFail'] = false;
      }
    }
    catch (PDOException $ex) {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
    }
}

//Handles updates on Heroku and Locally. Due to a quirk with Heroku, the exception
//handling must be present or else a fatal error will cause the page to stop rendering
//upon a failed database query.
function update($update) {
    try {
      if (!$update->execute())
      {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
      }
      else
      {
        echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
        $_SESSION['dbFail'] = false;
      }
    }
    catch (PDOException $ex) {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
    }
}


//Handles deletions on Heroku and Locally. Due to a quirk with Heroku, the exception
//handling must be present or else a fatal error will cause the page to stop rendering
//upon a failed database query.
function delete($delete) {
    try {
      if (!$delete->execute())
      {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
      }
      else
      {
        echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
        $_SESSION['dbFail'] = false;
      }
    }
    catch (PDOException $ex) {
        echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
        $_SESSION['dbFail'] = true;
    }
}


function deleteCustomer($db, $id) {

  //We want our deletion to be atomic
  $db->beginTransaction();

  try {
    $delete = $db->prepare("DELETE FROM customer_contact WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    //Error occured. Indicate error by returning 0.
    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer_employee WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer_location WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer_printer WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer_scanner WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer_solution WHERE customer_id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    $delete = $db->prepare("DELETE FROM customer WHERE id = :id;");
    $delete->bindValue(':id',$id, PDO::PARAM_INT);

    if(!$delete->execute()) {
      $db->rollback();
      return 0;
    }

    //Deletions completed successfully
    $db->commit();
    return 1;
  }
  catch (PDOException $ex) {
    //Error occurred. Indicate the deletion did not complete.
    $db->rollback();
    return 0;
  }
}


?>