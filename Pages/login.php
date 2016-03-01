<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script> 
      $(function(){
        $("#header").load("header.php"); 
        $("#footer").load("footer.html"); 
      });
    </script>
    <title>Template</title>
  </head>

  <body>
    <div id="header"></div>

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
          $mysqli = new mysqli($database_host, $database_user, 
                               $database_pass, $database_name);
          //check database connection
          if($mysqli -> connect_error) 
          {
            die('Connect Error ('.$mysqli -> connect_errno.') '
                .$mysqli -> connect_error);
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
                    ."Confirm password:<br><input name='passwordConfirm' "
                    ."type='password'><br>"
                    ."<input name='registered' type='submit' value='Register'>"
                  ."</form>";
          }
          //else if the user filled in the registration form
          else if(isset($_POST['registered']))
          {
            //check all values were entered
            if(!(empty($_POST['firstName']) || empty($_POST['surname']) 
               || empty($_POST['email']) || empty($_POST['username'])
               || empty($_POST['password']) 
               || empty($_POST['passwordConfirm'])))
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
                $query = "INSERT INTO SB_USER_INFO (userFirstName, userSurname,"
                         ." userEmail,  userScreenName) VALUES ('$firstName', "
                         ."'$surname', '$email', '$username')";
                if ($mysqli->query($query) === TRUE) 
                {
                  echo "New user created successfully";
                }
                else 
                {
                  die('Connect Error ('.$mysqli -> connect_errno.') '
                      .$mysqli -> connect_error);
                }
                //retrieve the userID
                $query = "SELECT userID FROM SB_USER_INFO WHERE "
                         ."userScreenName='$username'";
                $result = $mysqli -> query();
                //check that a user exists
                if($result -> num_rows == 1)
                {
                  //get the relevant user's ID
                  $userIDArray = $result -> fetch_assoc();
                  $userID = $userIDArray['userID'];
                  //insert the hashed password and the salt
                  $query = "INSERT INTO SB_LOGIN_CREDENTIALS (userID, "
                           ."userPasswordHash, userSalt) VALUES ('$userID', "
                           ."'$passwordHash', '$hexedSalt')";
                  if ($mysqli->query($query) === TRUE) 
                  {
                    echo "New credentials created successfully";
                  }
                  else 
                  {
                    die('Connect Error ('.$mysqli -> connect_errno.') '
                        .$mysqli -> connect_error);
                  }
                }
                //password does not match confirmed password
                else
                {
                  //reproduce form with missing items from registration form.
              
                  //set variables to blank
                  $firstName = "";
                  $surname = "";
                  $email = "";
                  $username = "";
                  $password = "";
                  $passwordConfirm = "";
                  
                  //get entered values
                  if(isset($_POST['firstName']))
                  {
                    $firstName = $_POST['firstName'];
                  }
                  if(isset($_POST['surname']))
                  {
                    $surname = $_POST['surname'];
                  }
                  if(isset($_POST['email']))
                  {
                    $email = $_POST['email'];
                  }
                  if(isset($_POST['username']))
                  {
                    $username = $_POST['username'];
                  }
                  //echo error message and display the form
                  echo "Password does not match the password confirmation <br>";
                  echo "<form method='post'>"
                        ."First name:<br><input name='firstName' type='text' "
                        ."value='$firstName'><br>"
                        ."Surname:<br><input name='surname' type='text' "
                        ."value='$surname'><br>"
                        ."Email address:<br><input name='email' type='email' "
                        ."value='$email'><br>"
                        ."Username:<br><input name='username' type='text' "
                        ."value='$username'><br>"
                        ."Password:<br><input name='password' type='password'>"
                        ."<br>"
                        ."Confirm password:<br><input name='passwordConfirm' "
                        ."type='password'><br>"
                        ."<input name='registered' type='submit' "
                        ."value='Register'>"
                      ."</form>";
                }
              }
            }
            else
            {
              //reproduce form with missing items from registration form.
              
              //set variables to blank
              $firstName = "";
              $surname = "";
              $email = "";
              $username = "";
              $password = "";
              $passwordConfirm = "";
              
              //get entered values
              if(isset($_POST['firstName']))
              {
                $firstName = $_POST['firstName'];
              }
              if(isset($_POST['surname']))
              {
                $surname = $_POST['surname'];
              }
              if(isset($_POST['email']))
              {
                $email = $_POST['email'];
              }
              if(isset($_POST['username']))
              {
                $username = $_POST['username'];
              }
              //echo the form
              echo "<form method='post'>"
                    ."First name:<br><input name='firstName' type='text' "
                    ."value='$firstName'><br>"
                    ."Surname:<br><input name='surname' type='text' "
                    ."value='$surname'><br>"
                    ."Email address:<br><input name='email' type='email' "
                    ."value='$email'><br>"
                    ."Username:<br><input name='username' type='text' "
                    ."value='$username'><br>"
                    ."Password:<br><input name='password' type='password'><br>"
                    ."Confirm password:<br><input name='passwordConfirm' "
                    ."type='password'><br>"
                    ."<input name='registered' type='submit' value='Register'>"
                  ."</form>";
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
              $query = "SELECT * FROM SB_USER_INFO WHERE "
                        ."userScreenName='$username'";
              $result = $mysqli -> query($query);
              if($result->num_rows == 0)
              {
                //incorrect username
                //do not need to do anything as this will be tested for again
              }
              else if($result->num_rows == 1)
              {
                $userIDArray = $result->fetch_assoc();
                $userID = $userIDArray['userID'];
                //username accepted but just to make sure...
                if(strcmp($username, $userIDArray['userScreenName']))
                {
                  //THIS SHOULD NEVER HAPPEN
                  echo "<a href='./Feedback.html'>Catastrophic failure: user "
                       ."mismatch. Please click here to report this using the "
                       ."feedback form</a><br>";
                }
                else
                {
                  //get the user credentials
                  $query = "SELECT * FROM SB_LOGIN_CREDENTIALS WHERE "
                           ."userID='$userID'";
                  $result = $mysqli -> query($query);
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
                    //store the user screen name and the userID to be used
                    //on other pages
                    $_SESSION['userName'] = $username;
                    $_SESSION['userID'] = $userID;
                  }
                }
              }
              //multiple users with the same username
              else
              {
                //THIS SHOULD NEVER EVER HAPPEN
                echo "<a href='./Feedback.html'>Catastrophic failure: multiple "
                     ."users. Please click here to report this using the "
                     ."feedback form</a>";
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
                      ."Username:<br><input type='text' name='username' "
                      ."value='$username'><br>"
                      ."<Password<br><input type='password' name='password'>"
                      ."<br>"
                      ."<input type='submit' name='login' value='login'><br>"
                    ."</form>"
                    ."<form method='post'>"
                      ."<input type='submit' name='register' "
                      ."value='Click Here to sign up'>"
                    ."</form>";
              }
            }
            //else no attempt to use page has been made so display standard form
            else
            {
              //display standard login form
              echo "<form method='post'>"
                      ."Username:<br><input type='text' name='username'><br>"
                      ."Password:<br><input type='password' name='password'>"
                      ."<br>"
                      ."<input type='submit' name='login' value='login'><br>"
                    ."</form>"
                    ."<form method='post'>"
                      ."<input type='submit' name='register' "
                      ."value='Click Here to sign up'>"
                    ."</form>";
            }
          }
        ?>
      </div>
    </div>
    <div id="footer"></div>
  </body>
</html>
