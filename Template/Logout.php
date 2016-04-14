<!DOCTYPE html>
<html><body>
<?php
  session_start();
  if(session_destroy())
  {
    session_unset(); // clear the $_SESSION variable
    if(isset($_COOKIE[session_name()])) 
    {
      setcookie(session_name(),'',time()-3600); # Unset the session id
    }
    header("Location: /Pages/AccountManagement.php");
    die();
  }
  else
  {
    echo "AN ERROR OCCURED";
  }
?>
</body></html>
