<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Login.css">
    <title>Sign Up/Log In</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

        <?php
          if(!(isset($_SESSION['userID']) && isset($_SESSION['userName'])))
          {
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
    echo "<div class='heading'>
      <div class='container'>
        <h1>Sign Up</h1>
      </div>
    </div>
	      
    <div class='body'>
      <div class='container'>";
              echo "<div id='register'><form method='post'>"
                      ."First name:<br><input name='firstName' type='text'><br>"
                      ."Surname:<br><input name='surname' type='text'><br>"
                      ."Email address:<br><input name='email' type='email'><br>"
                      ."Username:<br><input name='username' type='text'><br>"
                      ."Password:<br><input name='password' type='password'>"
                      ."<br>"
                      ."Confirm password:<br><input name='passwordConfirm' "
                      ."type='password'><br>"
                      ."<input name='registered' type='submit' "
                      ."value='Register'>"
                    ."</form></div>";
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
                $firstName = test_input($_POST['firstName']);
                $surname = test_input($_POST['surname']);
                $email = test_input($_POST['email']);
                $username = test_input($_POST['username']);
                $password = test_input($_POST['password']);
                $passwordConfirm = test_input($_POST['passwordConfirm']);
                //check if username or email exists in DB
                //if password matches confirmation password
                if(strcmp($password, $passwordConfirm) == 0)
                {
                  //generate the user salt
                  $generatedSalt = openssl_random_pseudo_bytes(32);
                  //convert the salt to text
                  $hexedSalt = bin2hex($generatedSalt);
                  //append the password to the salt
                  $saltedPasswordPreHash = $hexedSalt.$password;
                  //hash the salted password using sha512
                  $passwordHash = hash("sha512", $saltedPasswordPreHash);
                  
                  //insert all user info
                  $sql = $mysqli -> prepare("INSERT INTO SB_USER_INFO "
                                            ."(userFirstName, userSurname, "
                                            ."userEmail,  userScreenName) "
                                            ."VALUES (?,?,?,?)");
                  $sql -> bind_param("ssss", $firstName, $surname, $email, 
                                     $username);
                  $sql -> execute();
                  $sql -> close();
                  //retrieve the userID
                  $resultUID = array();
                  $resultUIDRow = array();
                  $sql = $mysqli -> prepare("SELECT userID FROM SB_USER_INFO "
                                            ."WHERE userScreenName=?");
                  $sql -> bind_param("s", $username);
                  $sql -> execute();
                  $sql -> store_result();
                  $sql -> bind_result($userID);
                  while($sql -> fetch())
                  {
                    $resultUIDRow['userID'] = $userID;
                    $resultUID[] = $resultUIDRow;
                  }
                  $sql -> close();
                  //check that a user exists
                  if(count($resultUID) == 1)
                  {
                    //get the relevant user's ID
                    $userID = $resultUID[0]['userID'];
                    //insert the hashed password and the salt
                    $sql = $mysqli -> prepare("INSERT INTO SB_LOGIN_CREDENTIALS"
                                              ." (userID, userPasswordHash, "
                                              ."userSalt) VALUES (?,?,?)");
                    $sql -> bind_param("sss", $userID, $passwordHash, 
                                       $hexedSalt);
                    $sql -> execute();
                    $sql -> close();
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
                    
                    //get entered values
                    if(isset($_POST['firstName']))
                    {
                      $firstName = test_input($_POST['firstName']);
                    }
                    if(isset($_POST['surname']))
                    {
                      $surname = test_input($_POST['surname']);
                    }
                    if(isset($_POST['email']))
                    {
                      $email = test_input($_POST['email']);
                    }
                    if(isset($_POST['username']))
                    {
                      $username = test_input($_POST['username']);
                    }
                    //echo error message and display the form
    echo "<div class='heading'>
      <div class='container'>
        <h1>Sign Up</h1>
      </div>
    </div>
	      
    <div class='body'>
      <div class='container'>";
                    echo "<div id='register'><form method='post'>"
                          ."<div id='invalid'>Password and confirm password do not match.</div><br>"
                          ."First name:<br><input name='firstName' type='text' "
                          ."value='$firstName'><br>"
                          ."Surname:<br><input name='surname' type='text' "
                          ."value='$surname'><br>"
                          ."Email address:<br><input name='email' type='email' "
                          ."value='$email'><br>"
                          ."Username:<br><input name='username' type='text' "
                          ."value='$username'><br>"
                          ."Password:<br><input name='password' "
                          ."type='password'><br>"
                          ."Confirm password:<br><input name='passwordConfirm' "
                          ."type='password'><br>"
                          ."<input name='registered' type='submit' "
                          ."value='Register'>"
                        ."</form></div>";
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
                  $firstName = test_input($_POST['firstName']);
                }
                if(isset($_POST['surname']))
                {
                  $surname = test_input($_POST['surname']);
                }
                if(isset($_POST['email']))
                {
                  $email = test_input($_POST['email']);
                }
                if(isset($_POST['username']))
                {
                  $username = test_input($_POST['username']);
                }
    echo "<div class='heading'>
      <div class='container'>
        <h1>Sign Up</h1>
      </div>
    </div>
	      
    <div class='body'>
      <div class='container'>";
                //echo the form
                echo "<div id='register'><form method='post'>"
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
                    ."</form></div>";
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
                $username = test_input($_POST['username']);
                $enteredPassword = test_input($_POST['password']);
                //get user credentials from DB
                $resultCRED = array();
                $resultCREDRow = array();
                $sql = $mysqli -> prepare("SELECT * FROM SB_USER_INFO WHERE "
                                          ."userScreenName=?");
                $sql -> bind_param("s", $username);
                $sql -> execute();
                $sql -> store_result();
                $sql -> bind_result($userID, $userScreenName, $userFirstName, 
                                    $userSurname, $userEmail);
                while($sql -> fetch())
                {
                  $resultCREDRow['userID'] = $userID;
                  $resultCREDRow['userFirstName'] = $userFirstName;
                  $resultCREDRow['userSurname'] = $userSurname;
                  $resultCREDRow['userScreenName'] = $userScreenName;
                  $resultCREDRow['userEmail'] = $userEmail;
                  $resultCRED[] = $resultCREDRow;
                }
                $sql -> close();
                if(count($resultCRED) == 0)
                {
                  //incorrect username
                  //do not need to do anything as this has the same error as
                  //incorrect password
                }
                else if(count($resultCRED) == 1)
                {
                  $userIDArray = $resultCRED[0];
                  $userID = $userIDArray['userID'];
                  $username = $userIDArray['userScreenName'];
                  //get the user credentials
                  $resultCRED2 = array();
                  $resultCRED2Row = array();
                  $sql = $mysqli -> prepare("SELECT * FROM SB_LOGIN_CREDENTIALS"
                                            ." WHERE userID=?");
                  $sql -> bind_param("s", $userID);
                  $sql -> execute();
                  $sql -> store_result();
                  $sql -> bind_result($userID, $userSalt, $userPasswordHash);
                  while($sql -> fetch())
                  {
                    $resultCRED2Row['userID'] = $userID;
                    $resultCRED2Row['userSalt'] = $userSalt;
                    $resultCRED2Row['userPasswordHash'] = $userPasswordHash;
                    $resultCRED2[] = $resultCRED2Row;
                  }
                  $sql -> close();
                  //user has info but no credentials
                  if(count($resultCRED2) > 1)
                  {
                    //multiple passwords for one user
                    //CANNOT HAPPEN
                  }
                  else if(count($resultCRED2) == 1)
                  {
                    //store the credentials for use
                    $userCredentials = $resultCRED2[0];
                    $storedSalt = $userCredentials['userSalt'];
                    $storedPasswordHash = $userCredentials['userPasswordHash'];
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
                    //store the user screen name and the userID to be used
                    //on other pages
                    $_SESSION['userName'] = $username;
                    $_SESSION['userID'] = $userID;
                  }
                }
                //multiple users with the same username
                else
                {
                  //THIS SHOULD NEVER EVER HAPPEN
                  echo "<a href='./Feedback.php'>Catastrophic failure: multiple"
                       ." users. Please click here to report this using the "
                       ."feedback form</a>";
                }
                //if successfully logged in
                if($login)
                {
                  //redirect user
                  header("Location: /Pages/AccountManagement.php");
                  die();
                }
                //login failed username or password checks
                else
                {
    echo "<div class='heading'>
      <div class='container'>
        <h1>Log In</h1>
      </div>
    </div>
	      
    <div class='body'>
      <div class='container'>";
                  //redisplay logn form with entered username but not password
                  echo "<div id='login'><form method='post'>"
                        ."<div id='invalid'>Invalid username or password</div><br>"
                        ."Username:<input type='text' name='username'><br><br>"
                        ."Password:<input type='password' name='password'>"
                        ."<br><br>"
                        ."<input id='loginButton' type='submit' name='login' value='LOG IN'><br>"
                      ."<p><a href='#'>Forgot your username or password?</a></p>"
                      ."</form>"
                      ."<p><br>Don't have a Study Buddy account?</p>"
                      ."<form method='post'>"
                        ."<input type='submit' name='register' "
                        ."value='Click Here to sign up'>"
                      ."</form></div>";
                }
              }
              //else no attempt to use page has been made 
              //so display standard form
              else
              {
    echo "<div class='heading'>
      <div class='container'>
        <h1>Log In</h1>
      </div>
    </div>
	      
    <div class='body'>
      <div class='container'>";
                //display standard login form
                echo "<div id='login'><form method='post'>"
                        ."<br>Username:<input type='text' name='username'><br><br>"
                        ."Password:<input type='password' name='password'>"
                        ."<br><br>"
                        ."<input id='loginButton' type='submit' name='login' value='LOG IN'><br>"
                      ."<p><a href='#'>Forgot your username or password?</a></p>"
                      ."</form>"
                      ."<p><br>Don't have a Study Buddy account?</p>"
                      ."<form method='post'>"
                        ."<input type='submit' name='register' "
                        ."value='Click Here to sign up'>"
                      ."</form></div>";
              }
            }
          }
          else
          {
            header("Location: /Pages/AccountManagement.php");
            die();
          }
          function test_input($data) 
          {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = filter_var($data, FILTER_SANITIZE_STRING, 
                               FILTER_FLAG_STRIP_HIGH);
            return $data;
          }
        ?>
      </div>
    </div>
    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
  </body>
</html>
