<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
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
    $result = $mysqli -> query("SELECT reportReason FROM SB_REPORTED_QUESTIONS WHERE questionID='$questionID' AND userID='$userID'");
    $reportedQuestionsRow = $result -> fetch_assoc();
    $reportReason = $reportedQuestionsRow['reportReason'];
    $otherReason = $reportedQuestionsRow['otherReason'];    

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
    echo "<h3>".$moduleDescription."</h3><br>";
    if ($questionRisk > 100)
    {
      echo "<h3>Your question has been reported by several other users.</h3>";
      echo "<h3>Please edit and fix your question.</h3>";
      echo "<h3>Report Reasons:</h3>";
      echo "<ul>";
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
    }
    echo "</ul>";
    echo "
      <form method='post'>
      <p>
      Question:<br>
      <textarea name='question' rows='3' cols='80'>.$questionContent.</textarea><br>";
      $answerNumber = 0;
      foreach($answers as $answer)
      {
        $answerNumber = $answerNumber + 1;
        echo "Answer ".$answerNumber." <input type='text' name='ans[0][0]' size='64' value='"
             .$answer['answerContent']."'>";
        if ($answer['answerCorrect'] == 1)
          echo "<input type='checkbox' name='ans[0][1]' checked><br>";
        else
          echo "<input type='checkbox' name='ans[0][1]' ><br>";
      }

  ?>

  <button id="closeButton" onclick="self.close()">Close</button>
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
