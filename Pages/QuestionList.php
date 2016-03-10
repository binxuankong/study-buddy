<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/QuestionList.css">
    <script src="./ReportButton.js"></script>
    <script src="jquery.js"></script>
    <title>List of Questions</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

  <?php
    //import database credentials
    require_once('../config.inc.php');
    //start a session
    session_start();
    //DATABASE CONNECTION-----------------------------------------------------//
    //create database connection
    $mysqli = new mysqli($database_host, $database_user,
                         $database_pass, $database_name);

    //check for connection errors kill page if found
    if($mysqli -> connect_error)
    {
      die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
    }

    $module = $_GET['module'];
    $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
    $moduleNameRow = $result -> fetch_assoc();
    $moduleName = $moduleNameRow['moduleName'];
    $result = $mysqli -> query("SELECT moduleDescription FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
    $moduleDescriptionRow = $result -> fetch_assoc();
    $moduleDescription = $moduleDescriptionRow['moduleDescription'];
    $result = $mysqli -> query("SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
    $moduleIDRow = $result -> fetch_assoc();
    $moduleID = $moduleIDRow['moduleID'];
    $result = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE moduleID='$moduleID'");
    $allQuestions = array();
    while($row = $result->fetch_assoc())
    {
      $allQuestions[] = $row;
    }
    echo "<div class='heading'>
      <div class='container'>
        <h1 id='moduleID'>".$module."</h1>
      </div>
    </div>

    <div class='body'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-1'>
          </div>
          <div class='col-md-10'>";
    echo "<h2>".$moduleName."</h2>";
    echo "<p>".$moduleDescription."</p><br>";
    echo "<table>";
    $questionNumber = 0;
    $questionArray = array();
    foreach ($allQuestions as $currentRow)
    {
      $question = $currentRow['questionContent'];
      $questionID = $currentRow['questionID'];
      $questionArray[] = array();
      $questionArray[$questionNumber][] = $questionID;

      echo "<tr><td>";
      echo $questionNumber + 1;
      echo ". ".$question;

      $result = $mysqli -> query("SELECT * FROM SB_ANSWERS WHERE questionID='$questionID'");
      $answers = array();
      while($answerRow = $result->fetch_assoc())
      {
        $answers[] = $answerRow;
      }

      echo "<ul>";
      $answerNumber = 0;
      foreach($answers as $answer)
      {
        $answerNumber = $answerNumber + 1;
        echo "<li>".$answer['answerContent'];
        echo "<br>";
        $questionArray[$questionNumber][] = $answer['answerID'];
      }
      echo "</ul><br>";
      $questionNumber = $questionNumber + 1;

      echo "</td><td width='100px'>";
      echo "<button id='reportButton' onclick='reportQuestion()'>Report this question</button>";
      echo "</td></tr>";
    }
    echo "</table>";
  ?>

  <a href="SubmitQuestion.php"><button id="addQuestion">Add more questions</button></a><br>
  <button id="reportModule" onclick='reportModule()'>Report this module</button><br>
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
