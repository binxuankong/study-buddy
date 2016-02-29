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
        <h1>Sign up / Login</h1>
      </div>
    </div>
	      
    <div class="body">
      <div class="container">
        <?php
          //create database connection object
          require_once('../config.inc.php');
          $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
          //check database connection
          if($mysqli -> connect_error) 
          {
            die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
          }
          //if the user clicked the sign up button
          if(isset($_POST['register']))
          {
            //display the sign up form
            echo "<form method='post'>"
                    ."First name:<br><input name='firstName' type='text'><br>"
                    ."Surname:<br><input name='surname' type='text'><br>"
                    ."Email address:<br><input name='email' type='email'><br>"
                    ."Username:<br><input name='username' type='text'><br>"
                    ."Password:<br><input name='password' type='password'><br>"
                    ."Confirm password:<br><input name='passwordConfirm' type='password'><br>"
                    ."<input name='registered' type='submit' value='Register'>"
                  ."</form>";
          }
          //else if the user filled in the registration form
          else if(isset($_POST['registered']))
          {
            //check all values were entered
            if(isset($_POST['firstName']) && $_POST['surname'] && $_POST['email']
               && $_POST['username'] && $_POST['password'] && $_POST['passwordConfirm'])
            {
              //store the form values for use.
              $firstName = $_POST['firstName'];
              $surname = $_POST['surname'];
              $email = $_POST['email'];
              $username = $_POST['username'];
              $password = $_POST['password'];
              $passwordConfirm = $_POST['passwordConfirm'];
              //check if username or email exists in DB
              //if password matches confirmation password
              if(strcmp($password, $passwordConfirm) == 0)
              {
                //generate the user salt
                $generatedSalt = openssl_random_pseudo_bytes(32);
                //convert the salt to text
                $hexedSalt = bin2hex($generatedSalt);
                //appent the password to the salt
                $saltedPasswordPreHash = $hexedSalt.$password;
                //hash the salted password using sha512
                $passwordHash = hash("sha512", $saltedPasswordPreHash);
                
                //insert all user info
                $query = "INSERT INTO SB_USER_INFO (userFirstName, userSurname, userEmail,  userScreenName) VALUES ('$firstName', '$surname', '$email', '$username')";
                if ($mysqli->query($query) === TRUE) 
                {
                  echo "New record created successfully";
                }
                else 
                {
                  echo "Error: " . $query . "<br>" . $mysqli->error;
                }
                //retrieve the userID
                $result = $mysqli -> query("SELECT userID FROM SB_USER_INFO WHERE userScreenName='$username'");
                //check that a user exists
                if($result -> num_rows == 1)
                {
                  //get the relevant user's ID
                  $userIDArray = $result -> fetch_assoc();
                  $userID = $userIDArray['userID'];
                  //insert the hashed password and the salt
                  $query = "INSERT INTO SB_LOGIN_CREDENTIALS (userID, userPasswordHash, userSalt) VALUES ('$userID', '$passwordHash', '$hexedSalt')";
                  if ($mysqli->query($query) === TRUE) 
                  {
                    echo "New record created successfully";
                  }
                  else 
                  {
                    echo "Error: " . $query . "<br>" . $mysqli->error;
                  }
                }
                //something went wrong
                else
                {}
              }
            }
            else
            {
              //reproduce form with missing items from registration form.
            }
          }
          //user attempted to login
          else
          {
            if(isset($_POST['username']) && isset($_POST['password']))
            {
              //assume login will fail
              $login = false;
              
              //get username and entered password
              $username = $_POST['username'];
              $enteredPassword = $_POST['password'];
              
              //get user credentials from DB
              $result = $mysqli -> query("SELECT * FROM SB_USER_INFO WHERE userScreenName='$username'");
              if($result->num_rows == 0)
              {
                //incorrect username
              }
              else if($result->num_rows == 1)
              {
                $userIDArray = $result->fetch_assoc();
                $userID = $userIDArray['userID'];
                //username accepted but just to make sure...
                if(strcmp($username, $userIDArray['userScreenName']))
                {
                  //THIS SHOULD NEVER HAPPEN
                  echo "<a href='./Feedback.html'>Catastrophic failure: user mismatch. Please click here to report this using the feedback form</a><br>";
                }
                else
                {
                  //get the user credentials
                  $result = $mysqli -> query("SELECT * FROM SB_LOGIN_CREDENTIALS WHERE userID='$userID'");
                  //user has info but no credentials
                  if($result->num_rows == 0)
                  {
                    //Password not set. fix this.
                  }
                  else if($result->num_rows == 1)
                  {
                    //store the credentials for use
                    $userCredentials = $result->fetch_assoc();
                    $storedSalt = $userCredentials['userSalt'];
                    $storedPasswordHash = $userCredentials['userPasswordHash'];
                  }
                  else
                  {
                    //multiple user passwords stored ????
                  }
                  //add the password to the retrieved salt
                  $passwordSalted = $storedSalt.$enteredPassword;
                  //hash the salted password
                  $enteredPasswordHash = hash("sha512", $passwordSalted);
                  //compare the entered passwords hash to the stored hash
                  if($enteredPasswordHash == $storedPasswordHash)
                  {
                    //set login to true to allow the user to login
                    $login = true;
                    //start a session to store login information
                    session_start();
                    //store the user screen name and the userID to be used elsewhere
                    $_SESSION['userName'] = $username;
                    $_SESSION['userID'] = $userID;
                  }
                }
              }
              //multiple users with the same username
              else
              {
                //THIS SHOULD NEVER EVER HAPPEN
                echo "<a href='./Feedback.html'>Catastrophic failure: multiple users. Please click here to report this using the feedback form</a>";
              }
              //if successfully logged in
              if($login)
              {
                //redirect user
                echo "LOGIN SUCCESSFUL";
              }
              //login failed username or password checks
              else
              {
                //redisplay logn form with entered username but not password
                echo "Invalid username or password";
                echo "<form method='post'>"
                      ."Username:<br><input type='text' name='username' value='$username'><br>"
                      ."<Password<br><input type='password' name='password'><br>"
                      ."<input type='submit' name='login' value='login'><br>"
                    ."</form>"
                    ."<form method='post'>"
                      ."<input type='submit' name='register' value='Click Here to sign up'>"
                    ."</form>";
              }
            }
            //else no attempt to use page has been made so display standard form
            else
            {
              //display standard login form
              echo "<form method='post'>"
                      ."Username:<br><input type='text' name='username'><br>"
                      ."Password:<br><input type='password' name='password'><br>"
                      ."<input type='submit' name='login' value='login'><br>"
                    ."</form>"
                    ."<form method='post'>"
                      ."<input type='submit' name='register' value='Click Here to sign up'>"
                    ."</form>";
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
