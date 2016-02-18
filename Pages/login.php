<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <title>Template</title>
  </head>

  <body>
    <div class="nav">
      <div class="container">
        <ul class="pull-left">
           <a href="../index.html"><img src="../Images/new_logo.png" alt="Study Buddy">
           <li id="webpagename">Study Buddy</li></a>
        </ul>
        <ul class="pull-right">
          <li><a href="#"><img src="../Images/new_user.png" alt="User Profile"></a></li>
          <li id="signup"><a href="#">Sign Up/Log In</a></li>
        </ul>
      </div>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Template</h1>
      </div>
    </div>
	      
    <div class="body">
      <div class="container">
        <?php
        //check if the username has been set
          if(isset($_POST['username']))
          {
            if(isset($_POST['password']))
            {
              //create database connection
              require_once('../config.inc.php');
              $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
              //check database connection
              if($mysqli -> connect_error) 
              {
                die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
              }
              //get username and password
              $username = $_POST['username'];
              $password = $_POST['password'];
              
              //get usercredentials
              $result = $mysqli -> query("SELECT * FROM SB_USER_INFO WHERE userScreenName='$username'");
              if($result->num_rows == 0)
              {
                //invalid username
                echo "<h3>Invalid username or password</h3>";
              }
              else if($result->num_rows == 1)
              {
                //username accepted
              }
              else
              {
                //multiple users with the same username
                //THIS SHOULD NEVER HAPPEN
                echo "<a href='./Feedback.html'>Catastrophic failure please click here to report this using the feedback form</a>";
              }
            }
          }
        ?>
      </div>
    </div>

    <div class="learn-more">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
             <h2><img src="../Images/new_logo.png" alt="Study Buddy"></img>Study Buddy</h2>
          </div>
          <div class="col-md-3">
            <h3>About Us</h3>
            <p>The team behind this website is the M3 Group of the School of Computer Science from the University of Manchester.</p>
            <p><a href="#">Learn more about each members of the team</a></p>
          </div>
          <div class="col-md-3">
            <h3>Get Started</h3>
            <p>Stop wasting precious time and come join us now to start your revision.</p>
            <p><a href="#">Get going with Study Buddy</a></p>
          </div>
          <div class="col-md-3">
            <h3>Feedback</h3>
            <p>Contact us if you encounter any problems or if you have any suggestions to improve our website and let us solve your problems.</p>
            <p><a href="Feedback.html">Send a feedback</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
