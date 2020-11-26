<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Create Module</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
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
          <?php          
          $codeErr = $nameErr = $descriptionErr = "";
          $name = $code = $description = $message = "";
          if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
          {           
            $submittingUserID = $_SESSION['userID'];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["name"])) {
                $nameErr = "Course name is required";
              } else {
                $name = test_input($_POST["name"]);
              }

              if (empty($_POST["code"])) {
                $codeErr = "Course code is required";
              } else {
                $code = strtoupper(test_input($_POST["code"]));
                if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
                  $codeErr = "Only letters, numbers, and white space allowed"; 
                }
              }

              if (empty($_POST["description"])) {
                $descriptionErr = "Course description is required";
              } else {
                $description = test_input($_POST["description"]);
              }

              if ($codeErr == "" and $nameErr == "" and $descriptionErr == "") {

                require_once('../config.inc.php');

                $mysqli = new mysqli($database_host, $database_user,
                                     $database_pass, $database_name);              

                if($mysqli -> connect_error) {
                  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
                } 

                // Parameterise SQL statement.
                $result = array();
                $resultRow = array();
                $sql = $mysqli -> prepare("SELECT * FROM SB_MODULE_INFO WHERE moduleCourseID=?");
                $sql -> bind_param("s", $code);
                $sql -> execute();
                $sql -> store_result();
                $sql -> bind_result($fetchedModuleID, $fetchedUserID, $fetchedModuleName, $fetchedModuleCourseID, $fetchedModuleDescription, $fetchedMRS);
                while($sql -> fetch())
                {
                  $resultRow['moduleID'] = $fetchedModuleID;
                  $resultRow['userID'] = $fetchedUserID;
                  $resultRow['moduleName'] = $fetchedModuleName;
                  $resultRow['moduleCourseID'] = $fetchedModuleCourseID;
                  $resultRow['moduleDescription'] = $fetchedModuleDescription;
                  $result[] = $resultRow;
                }
                $sql -> close();     
                if (count($result) > 0)
                {
                  $message = "The course entered already exists. Please check if all information is correct.";
                }
                else
                {

                  // Parameterise SQL statement.
                  $sql = $mysqli -> prepare("INSERT INTO SB_MODULE_INFO (userID, moduleName, moduleCourseID, moduleDescription) VALUES (?,?,?,?)");
                  $sql -> bind_param("ssss", $submittingUserID, $name, $code, $description);
                  $sql -> execute();
                  $sql -> close();
                  
                      $message = "<div class='successPage'>
                       <h2>Your module has successfully been created!</h2>
                       <img src='../Images/report_success.png'>
                       <h3>Thank you for contributing to <b>Study Buddy</b>.</h3>
                       <h3>You can view your module in the <a href='AllQuestions.php'>View All Questions</a> page.</h3>
                       <h3>You can submit question to your module <a href='SubmitQuestion.php'>here</a>.</h3>
                       <h3>You can create another module <a href='CreateModule.php'>here</a>.</h3>
                       </div>";

                  // Update the user quality of the creator.
                  $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$submittingUserID'");
                  $creatorQuestionQualityRow = $result -> fetch_assoc();
                  $creatorQuestionQuality = $creatorQuestionQualityRow['userQuestionQuality'];
                  $creatorQuestionQuality = $creatorQuestionQuality + 15;
                  if ($creatorQuestionQuality > 500) {
                    $creatorQuestionQuality = 500;
                  }
                  $updateCreatorQuality = "UPDATE SB_USER_INFO SET userQuestionQuality='$creatorQuestionQuality' WHERE userID='$submittingUserID'";
                  $mysqli->query($updateCreatorQuality);

                } // else

                $mysqli -> close();
               
              } // if

            }
          }
          else
          {
            echo "You must be signed in to create create a module.
                  <span class='dropt'><img src='../Images/information.png'>
                 <span style='width:500px;'>Only users with a Study Buddy account are able to create a module.</span></span><br>"
                 ."<a href='login.php'>Please click here to sign in or register</a>";
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            return $data;
          }


          ?>


          <?php 
            echo $message;
            echo "<br><br>";
          ?> 

      <?php
        if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
        {
          echo "
          <form method='post'>
	        <p>         
          Module Code:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The course code of the module.<br>The first part of the module code consists of a group of letters of the abbreviation of the course name.<br>The second part of the module code consists of a group of numbers.<br>The intial number indicates the level of the course unit.<br>The final number indicates the time period in which the course unit is offered.</span></span>
          <input type='text' name='code' placeholder='e.g. COMP16121' value='$code' required>
          <span class='error'>$codeErr</span>
          </p><br>

          Module Name:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The name of the module.<br>Prevent any spelling error in the name. Try to copy the module name as exact as possible.</span></span>
          <input type='text' name='name' size='50'
          placeholder='e.g. Object Orientated Programming with Java' value='$name' required>
          <span class='error'>$nameErr</span>
          </p><br>

          Module Description:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The description of the module.<br>The description does not have to be too detailed. Keep it clear and concise.<br>State the unit level and teaching period of the course unit if possible.</span></span>
          <span class='error'>$descriptionErr</span><br>
          <textarea name='description' placeholder='e.g. First Year Java Course for Computer Science' rows='4' cols='63' required>$description</textarea>
          <br><br><br>
          <input type='submit' value='Submit Module'>
          </form>";
        } else {
          echo "
          <form method='post'>
	        <p>         
          Module Code:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The course code of the module.<br>The first part of the module code consists of a group of letters of the abbreviation of the course name.<br>The second part of the module code consists of a group of numbers.<br>The intial number indicates the level of the course unit.<br>The final number indicates the time period in which the course unit is offered.</span></span>
          <input disabled type='text' name='code' placeholder='e.g. COMP16121' value='$code' required>
          <span class='error'>$codeErr</span>
          </p><br>

          Module Name:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The name of the module.<br>Prevent any spelling error in the name. Try to copy the module name as exact as possible.</span></span>
          <input disabled type='text' name='name' size='50'
          placeholder='e.g. Object Orientated Programming with Java' value='$name' required>
          <span class='error'>$nameErr</span>
          </p><br>

          Module Description:
          <span class='dropt'><img src='../Images/information.png'>
          <span style='width:500px;'>The description of the module.<br>The description does not have to be too detailed. Keep it clear and concise.<br>State the unit level and teaching period of the course unit if possible.</span></span>
          <span class='error'>$descriptionErr</span><br>
          <textarea disabled name='description' placeholder='e.g. First Year Java Course for Computer Science' rows='4' cols='63' required>$description</textarea>
          <br><br><br>
          <input disabled id ='disabled' type='submit' value='Submit Module'>
          </form>";
        }
      ?>
          
          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>
