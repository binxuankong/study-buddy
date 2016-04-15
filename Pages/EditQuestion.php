<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/EditQuestion.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Edit Question</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

  <?php
    //import database credentials
    require_once('../config.inc.php');
    //DATABASE CONNECTION-----------------------------------------------------//
    //create database connection
    $mysqli = new mysqli($database_host, $database_user,
                         $database_pass, $database_name);

    //check for connection errors kill page if found
    if($mysqli -> connect_error)
    {
      die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
    }

    $userID = $_SESSION['userID'];
    $questionContent = $_GET['question'];
    // SB_QUESTIONS
    $result = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE questionContent='$questionContent'");
    $questionRow = $result -> fetch_assoc();
    $questionID = $questionRow['questionID'];
    $moduleID = $questionRow['moduleID'];
    $questionRisk = $questionRow['questionRisk'];
    // SB_MODULE_INFO
    $result = $mysqli -> query("SELECT * FROM SB_MODULE_INFO WHERE moduleID='$moduleID'");
    $moduleRow = $result -> fetch_assoc();
    $moduleName = $moduleRow['moduleName'];
    $moduleCourseID = $moduleRow['moduleCourseID'];
    $moduleDescription = $moduleRow['moduleDescription'];
    // SB_ANSWERS
    $result = $mysqli -> query("SELECT * FROM SB_ANSWERS WHERE questionID='$questionID'");
    $answers = array();
    while($answerRow = $result->fetch_assoc())
    {
       $answers[] = $answerRow;
    }
    // SB_REPORTED_QUESTIONS
    $result = $mysqli -> query("SELECT * FROM SB_REPORTED_QUESTIONS WHERE questionID='$questionID' AND userID='$userID'");
    $reportedQuestionsRow = $result -> fetch_assoc();
    $reportReason = $reportedQuestionsRow['reportReason'];
    $otherReason = $reportedQuestionsRow['otherReason'];

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      return $data;
    }

    $errorMessage = "";
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $goodQuestion = true;
      if(empty($_POST["question"]))
      {
        $errorMessage = "The question must not be empty.";
        $goodQuestion = false;
      }
      else
      {
        $question = test_input($_POST['question']);
        $ans = array();
        foreach($_POST['ans'] as $newAns)
        {
          $ansRow = array();
          $ansRow[] = test_input($newAns[0]);
          if(count($newAns) == 2)
          {
            $ansRow[] = 1;
          }
          else
          {
            $ansRow[] = 0;
          }
          $ans[] = $ansRow;
        }
        $numberOfAnswers = 0;
        $numberOfCorrectAnswers = 0;
        foreach($ans as $row)
        {
          if($row[1] == 1 && !empty($row[0]))
            $numberOfCorrectAnswers++;
          if(!empty($row[0]))
            $numberOfAnswers++;
        }
        $answers = array();
        if($numberOfCorrectAnswers <= 0)
        {
          $errorMessage = "There must be at least one correct answer.";
          $goodQuestion = false;
        }
        if($numberOfCorrectAnswers >= $numberOfAnswers)
        {
          $errorMessage = "The number of correct answers must be one less than the number of answer choices";
          $goodQuestion = false;
        }
        foreach($ans as $row)
        {
          if(empty($row[0]))
          {
            $errorMessage = "The answer must not be empty.";
            $goodQuestion = false;
          }
          $answer[] = $row;
        }
        if(count($answer) == 0)
        {
          $errorMessage = "There must be at least two answer choices.";
          $goodQuestion = false;
        }
      }
      // Save the edited question to the database.
      if($goodQuestion)
      {
        $deleteAnswers = "DELETE FROM SB_ANSWERS WHERE questionID='$questionID'";
        $mysqli->query($deleteAnswers);
        $updateQuestion = "UPDATE SB_QUESTIONS SET questionContent='$question' WHERE questionID='$questionID'";
        $mysqli->query($updateQuestion);
        foreach($ans as $ansRow)
        {
          $sql = $mysqli -> prepare("INSERT INTO SB_ANSWERS (questionID, answerContent, answerCorrect) VALUES (?,?,?)");
          $sql -> bind_param("sss", $questionID, $ansRow[0], $ansRow[1]);
          $sql -> execute();
          $sql -> close();
          $errorMessage ="<div class='successPage'> <h2>Your question has successfully been edited!</h2> <img src='../Images/report_success.png'> </div>";
        }
        // Reset questionRisk of the question.
        $updateQuestionRisk = "UPDATE SB_QUESTIONS SET questionRisk=0 WHERE questionID='$questionID'";
        $mysqli->query($updateQuestionRisk);
      }
    }

    echo "<div class='heading'>
      <div class='container'>
        <h1 id='moduleID'>Edit Question</h1>
      </div>
    </div>

    <div class='body'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-1'>
          </div>
          <div class='col-md-10'>";
    echo "<h2>".$moduleCourseID.": ".$moduleName."</h2>";
    echo "<p>".$moduleDescription."</p>";
    if ($questionRisk > 100)
    {
      echo "<h3>Your question has been reported by several other users.</h3>";
      echo "<p>Please edit and fix your question.<br><br>";
      echo "<b>Report Reasons:</b><br>";
      echo "<ol>";
      if (($reportReason - 64) >= 0)
      {
        $reportReason -= 64;
        echo "<li>The content of the question is offensive.</li>";
      }
      if (($reportReason - 32) >= 0)
      {
        $reportReason -= 32;
        echo "<li>Other reason(s): ".$otherReason.".</li>";
      }
      if (($reportReason - 16) >= 0)
      {
        $reportReason -= 16;
        echo "<li>The question is completely irrelevant.</li>";
      }
      if (($reportReason - 8) >= 0)
      {
        $reportReason -= 8;
        echo "<li>The question is not suitable for its module.</li>";
      }
      if (($reportReason - 4) >= 0)
      {
        $reportReason -= 4;
        echo "<li>The choices available for the question are irrelevant.</li>";
      }
      if (($reportReason - 2) >= 0)
      {
        $reportReason -= 2;
        echo "<li>The correct answer(s) for the question is(are) wrong.</li>";
      }
      if (($reportReason - 1) >= 0)
      {
        $reportReason -= 1;
        echo "<li>The question/choices contain spelling error.</li>";
      }
      echo "</ol><br></p>";
    }
    else
      echo "<br>";
    echo "<span class='error'>$errorMessage</span>";
    echo "
      <form method='post'>
      <p>
      Question:<br>
      <textarea name='question' rows='3' cols='80'>".$questionContent."</textarea><br>";
    $answerNumber = 0;
    $count = 0;
    foreach($answers as $answer)
    {
      $answerNumber = $answerNumber + 1;
      echo "Answer ".$answerNumber." <input type='text' name='ans[$count][0]' size='64'"
           ."value='".$answer['answerContent']."'> ";
      if ($answer['answerCorrect'] == 1)
        echo "<input type='checkbox' name='ans[$count][1]' value='1' checked><br>";
      else
        echo "<input type='checkbox' name='ans[$count][1]' ><br>";
      $count = $count + 1;
    }
    echo "
      <input type='submit' value ='Save Question'><br>
      <button id='closeButton' onclick='self.close()'>Close</button>
      </form>";

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
