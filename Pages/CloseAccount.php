<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Close Account</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Close Account</h1>
      </div>
    </div>
	      
    <div class="body">
      <div class="container">
        <?php
          if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
          {
            if(isset($_POST['accountClosed']))
            {
              require_once('../config.inc.php');
              $mysqli = new mysqli($database_host, $database_user,
                                       $database_pass, $database_name);              

              if($mysqli -> connect_error) 
              {
                die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
              }
              $sql = $mysqli -> prepare("DELETE FROM SB_USER_INFO WHERE userID=? AND userScreenName=?");
              $sql -> bind_param("ss", $_SESSION['userID'], $_SESSION['userName']);
              $sql -> execute();
              $sql -> close();
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
            }
            else
            { 
              echo "Clicking the button below will close your account. This cannot be undone. If you wish to use Study Buddy in the future you will have to create a new account. <br> This will remove all of your personal data from our database, It will not remove any questions or modules you have created <br>";
              echo "<form method='POST'><input type='submit' name='accountClosed' value='CLOSE ACCOUNT'></form>";
            }
          }
          else
          {
            echo "You are not logged in.";
            echo "<h3><a href='../index.php'>Click here to return to the homepage.</a></h3>";
            echo "<h3><a href='../index.php'>Click here to log in or sign up.</a></h3>";
          }
        ?>
      </div>
    </div>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>
