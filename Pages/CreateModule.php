<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <title>Create Module</title>
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

        <h1>Create a Module</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">


          <!-- Some code from www.w3school.com -->
          <?php  
          //Import database credentials
          //require_once('../config.inc.php');
          //create database conection
          //$mysqli = new mysqli($database_host, $database_user,
          //                     $database_pass, $database_name);
                               
          $codeErr = $nameErr = $descriptionErr = "";
          $name = $code = $description = $message = "";

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
              $nameErr = "Course name is required";
            } else {
              $name = test_input($_POST["name"]);
              if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed"; 
              }
            }

            if (empty($_POST["code"])) {
              $codeErr = "Course code is required";
            } else {
              $code = strtoupper(test_input($_POST["code"]));
            }

            if (empty($_POST["description"])) {
              $descriptionErr = "Course description is required";
            } else {
              $description = test_input($_POST["description"]);
            }

            if ($codeErr == "" and $nameErr == "" and $descriptionErr == "") {
              $group_dbnames = array(
                "2015_comp10120_m3",
              );

              require_once('../config.inc.php');

              $mysqli = new mysqli($database_host, $database_user,
                                   $database_pass, $database_name);              

              if($mysqli -> connect_error) {
                die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
              } 

              // Parameterise SQL statement.
              $sql = $mysqli -> prepare("SELECT * FROM SB_MODULE_INFO WHERE moduleCourseID=?");
              $sql -> bind_param("s", $code);
              $sql -> execute();

              $result = $mysqli -> query($sql);
                       
              if ($result -> num_rows > 0) {
                $message = "The course has already been created. Please check if all information is correct.";
              } else {

                // Parameterise SQL statement.
                $sql = $mysqli -> prepare("INSERT INTO SB_MODULE_INFO (moduleName, moduleCourseID, moduleDescription) VALUES (?,?,?)");
                $sql -> bind_param("sss", $name, $code, $description);
                $sql -> execute();

                $mysqli -> query($sql);
                $message = "Thank you for contributing to Study Buddy. The module is created successfully.";

              } // else

              $mysqli -> close();
             
            } // if

          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }


          ?>


          <?php 
            echo $message;
          ?>
          <br><br>
	      

          <form method="post">
	        <p>         
          Module Code:

          <input type="text" name="code" placeholder="e.g. COMP16121" value="<?php echo $code;?>">
          <span class="error"><?php echo $codeErr;?></span>

          <br><br>
          Module Name:
          <input type="text" name="name" size="50"
          placeholder="e.g. Object Orientated Programming with Java" value="<?php echo $name;?>">
          <span class="error"><?php echo $nameErr;?></span>
          <br><br>
          Module Description:<br>

          <textarea name="description" placeholder="e.g. First Year Java Course for Computer Science" 
          rows="4" cols="63"></textarea>

          <textarea name="description" placeholder="e.g. First Year Java Course for Computer Science" rows="4" cols="63"><?php echo $description;?></textarea>
          <span class="error"><?php echo $descriptionErr;?></span>

          <br><br><br>
          <input type="submit" value="Submit Module">
          </p>
          </form>

	      
          </div>
          <div class="col-md-1">
          </div>
        </div>
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
