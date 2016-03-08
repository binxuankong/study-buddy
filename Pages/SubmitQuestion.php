<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="./ExtraSubmitFields.js"></script>
    <title>Submit Question</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>
   <?php
#      $question = $moduleCourseID = $answer = "";
#      $questionErr = $answerErr = $moduleErr = "";
#      $correctAnswer = 0;
#      if($_SERVER['REQUEST_METHOD'] == 'POST')
#      {
#        echo "<h1>POSTED</h1>";
#        //Checks there exists a question
#        if (empty($_POST['question']))
#        {
#          $questionErr = "Please input a question";
#        }
#        else
#        {
#          $question = test_input($_POST['question']); //Sets question variable
#        }

#        if(empty($_POST['ans1']) or empty($_POST['ans2'])) //Checks at least 2 answers
#        {
#          $answerErr = " Please input at least 2 answers";
#        }

#        if(empty($_POST['correctAnswer'])) // At least one check box is checked
#        {
#          $answerErr = "Please check at least one answer to be correct";
#        }

#        if($answerErr="" and $questionErr="") //no errors
#        {
#          //opening databases connection
#          require_once('../config.inc.php');
#          $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
#          if($mysqli -> connect_error)
#          {
#            die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
#          }

#          //Get module ID for corresponding module code
#          $getModuleID = "SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID ='" . $code . "'";
#          $result = $mysqli -> query($getModuleID);

#          $moduleIDRow = $result -> fetch_assoc();
#          $moduleID = $moduleIDRow['moduleID'];

#          //Add question to question table with that module ID
#          $insertQuestion =" INSERT INTO SB_QUESTIONS (moduleID, questionContent)"
#                           ."VALUES ('" .$moduleID. "', '" . $question . "')";
#          $mysqli -> query($insertQuestion);

#          //Get new question ID
#          $getModuleID = "SELECT questionID FROM SB_QUESTIONS WHERE questionContent ='" . $question . "'";
#          $result = $mysqli -> query($getModuleID);

#          $questionIDRow = $result -> fetch_assoc();
#          $questionID = $moduleIDRow['questionID'];

#          //Add all answers to answer table with new question ID
#            //Check if box empty
#            for($count = 1; $count<=5; $count++)
#            {
#              if(!(empty($_POST["ans".$count]))) //Check if it's a correct answer
#              {
#                $answerCorrect = 1;
#                if(empty($_POST["correctAnswer".$count]))
#                {
#                  $answerCorrect = 0;
#                }
#                $currentAnswer = $_POST["ans".$count];
#                $insertAnswer = " INSERT INTO SB_ANSWERS(questionID, answerContent, answerCorrect)"
#                                ."VALUES ('" . $questionID . "', '" . $currentAnswer . "', '" . $answerCorrect . "')";
#                $mysqli -> query($insertAnswer);
#              }
#            }

#        }



#      }//First IF
#      require_once('../config.inc.php');
#      $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
#      if($mysqli -> connect_error)
#      {
#        die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
#      }

#      function test_input($data) 
#      {
#        $data = trim($data);
#        $data = stripslashes($data);
#        $data = htmlspecialchars($data);
#        return $data;
#      }
   ?>

    <div class="heading">
      <div class="container">
        <h1>Submit a Question</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
            <?php
              if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
              {  
                require_once('../config.inc.php');
                $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
                if($mysqli -> connect_error)
                {
                  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
                }
                $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO ORDER BY moduleID ASC");
                echo '<br><p>Choose a module to add a question to</p><select id="moduleDropdown" name="module">';
                echo "<option value='Choose a module'>Choose a module</option>";
                while($row = $result->fetch_assoc())
                {
                  $thismodule = $row["moduleCourseID"];

                  echo "<option value='$thismodule'>$thismodule</option>";
                }
                echo '</select><br><h3 id="errorLabel" class="error"></h3>';
                $mysqli -> close();
                echo "<form method='post'>"
                       ."<br>Enter the question:<br>"
                       ."<textarea name='question' rows='3' cols='80' placeholder='e.g. What is the value of the \$test in the following php statement, \$test  = false or true;'></textarea>"
                       ."<br><br>Enter up the answers for this question. if you need more you can add them by clicking the add more answers button"
                       ."<br>(check any answers that are correct)<br>"
                       ."<div id='AnswersFormDiv'>"
                         ."Answer 1 <input type='text' name='ans[0][0]' size='64'>"
                         ."<input type='checkbox' name='ans[0][1]' ><br>"

                         ."Answer 2 <input type='text' name='ans[1][0]' size='64'>"
                         ."<input type='checkbox' name='ans[1][1]'><br>"
                       ."</div>"
                       ."<br><br>"
                       ."<input type='submit' value='Submit Question'>"
                     ."</form>"
                   ."<input type='button' value='Add more answers' onClick='addInput(\"AnswersFormDiv\")'>";
                }
                else
                {
                  echo "You must be signed in to create submit a question.<br>"
                       ."<a href='login.php'>Please click here to sign in or register</a>";
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
