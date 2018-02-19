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

?>