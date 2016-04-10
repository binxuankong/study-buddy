<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="./ExtraSubmitFields.js"></script>
    <title>Study Buddy - Submit Question</title>
  </head>
  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>
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
                $submittingUserID = $_SESSION['userID'];
                require_once('../config.inc.php');
                $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
                if($mysqli -> connect_error)
                {
                  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
                }
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {
                  //validate all input
                  $module = test_input($_POST['module']);
                  $question = test_input($_POST['question']);
                  $ans = array();
                  foreach($_POST['ans'] as $newAns)
                  {
                    $ansRow = array();
                    $ansRow[] = test_input($newAns[0]);
                    if(count($newAns) == 2)
                    {
                      $ansRow[] = test_input($newAns[1]);
                    }
                    else
                    {
                      $ansRow[] = 0;
                    }
                    $ans[] = $ansRow;
                  }
                  //retrieve module ID
                  //validate legitimacy of answers and question
                  
                  //insert question into DB
                  $sql = $mysqli -> prepare("INSERT INTO SB_QUESTIONS (userID, moduleID, questionContent) VALUES (?,?,?)");
                  $sql -> bind_param("sss", $submittingUserID, $moduleID, $question);
                  $sql -> execute();
                  $sql -> close();
                  
                  $result = array();
                  $sql = $mysqli -> prepare("SELECT questionID FROM SB_QUESTIONS WHERE questionContent=?");
                  $sql -> bind_param("s", $question);
                  $sql -> execute();
                  $sql -> store_result();
                  $sql -> bind_result($fetchedQuestionID);
                  while($sql -> fetch())
                  {
                    $result[] = $fetchedQuestionID;
                  }
                  $sql -> close();
                  if(count($result) != 1)
                  {
                    die('Question submission failure');
                  }
                  else
                  {
                    $questionID = $result[0];
                    foreach($ans as $ansRow)
                    {
                      $sql = $mysqli -> prepare("INSERT INTO SB_ANSWERS (questionID, answerContent, answerCorrect) VALUES (?,?,?)");
                      $sql -> bind_param("sss", $questionID, $ansRow[0], $ansRow[1]);
                      $sql -> execute();
                      $sql -> close();
                    }
                    echo "Question Submitted. Thank you for contributing to Study Buddy";

                    // Update the user quality of the creator.
                    $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$submittingUserID'");
                    $creatorQuestionQualityRow = $result -> fetch_assoc();
                    $creatorQuestionQuality = $creatorQuestionQualityRow['userID'];
                    $creatorQuestionQuality = $creatorQuestionQuality + 5;
                    if ($creatorQuestionQuality > 500) {
                     $creatorQuestionQuality = 500;
                   }
                  }
                }
                else
                {
                  $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO ORDER BY moduleID ASC");
                  echo '<br><p>Choose a module to add a question to</p><form id="questionsForm"  method="post"><select id="moduleDropdown" name="module">';
                  echo "<option value='Choose a module'>Choose a module</option>";
                  while($row = $result->fetch_assoc())
                  {
                    $thismodule = $row["moduleCourseID"];

                    echo "<option value='$thismodule'>$thismodule</option>";
                  }
                  echo '</select><br><h3 id="errorLabel" class="error"></h3>';
                  $mysqli -> close();
                  echo "<br>Enter the question:<br>"
                         ."<textarea name='question' rows='3' cols='80' placeholder='e.g. What is the value of the \$test in the following php statement, \$test  = false or true;'></textarea>"
                         ."<br><br>Enter up the answers for this question. if you need more you can add them by clicking the add more answers button"
                         ."<br><input id='removable' type='button' value='Add more answers' onClick='addInput(\"AnswersFormDiv\")'>"
                         ."<br>(check any answers that are correct)<br>"
                         ."<div id='AnswersFormDiv'>"
                           ."Answer 1 <input type='text' name='ans[0][0]' size='64'> "
                           ."<input type='checkbox' name='ans[0][1]' ><br>"

                           ."Answer 2 <input type='text' name='ans[1][0]' size='64'> "
                           ."<input type='checkbox' name='ans[1][1]'><br>"
                         ."</div>"
                         ."<br><br>"
                         ."<input type='submit' value='Submit Question'>"
                       ."</form>";
                }
              }
              else
              {
                echo "You must be signed in to create submit a question.<br>"
                     ."<a href='login.php'>Please click here to sign in or register</a>";
                echo '<br><br><p>Choose a module to add a question to</p><form id="questionsForm"  method="post"><select disabled id="moduleDropdown" name="module">';
                echo "<option value='Choose a module'>Choose a module</option></select>";
                  echo "<br>Enter the question:<br>"
                         ."<textarea disabled name='question' rows='3' cols='80' placeholder='e.g. What is the value of the \$test in the following php statement, \$test  = false or true;'></textarea>"
                         ."<br><br>Enter up the answers for this question. if you need more you can add them by clicking the add more answers button"
                         ."<br><input disabled id='removableDisabled' type='button' value='Add more answers' onClick='addInput(\"AnswersFormDiv\")'>"
                         ."<br>(check any answers that are correct)<br>"
                         ."<div id='AnswersFormDiv'>"
                           ."Answer 1 <input disabled type='text' name='ans[0][0]' size='64'> "
                           ."<input disabled type='checkbox' name='ans[0][1]' ><br>"

                           ."Answer 2 <input disabled type='text' name='ans[1][0]' size='64'> "
                           ."<input disabled type='checkbox' name='ans[1][1]'><br>"
                         ."</div>"
                         ."<br><br>"
                         ."<input disabled id='disabled' type='submit' value='Submit Question'>";
              }
              function redisplayForm($error = "")
              {
                echo "<form id='questionsForm'  method='post'>"
                     ."<br>Enter the question:<br>"
                     ."<textarea name='question' rows='3' cols='80' placeholder='e.g. What is the value of the \$test in the following php statement, \$test  = false or true;'></textarea>"
                     ."<br><br>Enter up the answers for this question. if you need more you can add them by clicking the add more answers button"
                     ."<br><input id='removable' type='button' value='Add more answers' onClick='addInput(\"AnswersFormDiv\")'>"
                     ."<br>(check any answers that are correct)<br>"
                     ."<div id='AnswersFormDiv'>";
                $count = 0;
                foreach($_POST['ans'] as $ans)
                {
                  $value = "";
                  if(isset($ans[0]))
                  {
                    $value = $ans[0];
                  }
                  $displayCount = $count + 1;
                  echo "Answer $displayCount <input type='text' name='ans[$count][0]' size='64' value='$value'> ";
                  echo "input type='checkbox' name='ans[$count][1]' value='$ans[1]'><br>";
                  $count++;
                }
                echo "</div>"
                      ."<br><br>"
                      ."<input type='submit' value='Submit Question'>"
                     ."</form>";
              }
              function test_input($data)
              {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                return $data;
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
