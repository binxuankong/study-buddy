<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/ExercisePage.css">
    <script src="./ReportButton.js"></script>
    <title>Exercise Page</title>
  </head>
  <body>
    <div class="nav">
      <div class="container">
        <ul class="pull-left">
          <div id="logo"></div>
          <li id="webpagename">Study Buddy</li>
        </ul>
      </div>
    </div>
    <div class="heading">
      <div class="container">
        <h1>Exercise</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

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
    //create needed session variables
    if(!(isset($_SESSION['incorrectQuestions'])))
    {
      $_SESSION['incorrectQuestions'] = array();
    }
    if(!(isset($_SESSION['passedQuestions'])))
    {
      $_SESSION['passedQuestions'] = array();
    }
    if(!(isset($_SESSION['questionsAccessed'])))
    {
      $_SESSION['questionsAccessed'] = false;
    }

    //EXERCISE----------------------------------------------------------------//
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answered'])) //request method POST
    {
      $_SESSION['questionsAccessed'] = false;
      $module = $_GET['module'];
      $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
      $moduleNameRow = $result -> fetch_assoc();
      $moduleName = $moduleNameRow['moduleName'];
      echo "<h2>".$module.": ".$moduleName."</h2><br><br>";
      echo "<table>";
      $questions = $_SESSION['passedQuestions'];
      $correctQuestions = 0;
      for($questionCount = 0; $questionCount < count($questions); $questionCount++)
      {
        $correctlyAnswered = true;
        $question = $questions[$questionCount];
        for($count = 0; $count < count($question); $count++)
        {
          if($count == 0) //value is a question
          {
            $result = $mysqli -> query("SELECT questionContent FROM SB_QUESTIONS WHERE questionID='$question[0]'");
            if($result->num_rows == 1) //this is correct
            {
              $questionInfo = $result->fetch_assoc();
              echo "<tr><td>";
              echo $questionCount + 1;
              echo ". ".$questionInfo['questionContent']."<br><ul>";
            }
            else //this cannot happen
            {
              echo "ERROR CODE 4386346879346643986376439756346";
            }
          }
          else //value is an answer
          {
            $result = $mysqli -> query("SELECT * FROM SB_ANSWERS WHERE answerID='$question[$count]'");
            $answerInfo = $result->fetch_assoc();
            echo "<li>";
            $checkbox = "$questionCount,$count";
            if(isset($_POST[$checkbox]))
            {
              echo "<input type='checkbox' name='$checkbox' disabled checked>";
            }
            else
            {
              echo "<input type='checkbox' name='$checkbox' disabled>";
            }
            if(($answerInfo['answerCorrect'] != 0) Xor (isset($_POST[$checkbox]))) //user answered incorrectly
            {
              $correctlyAnswered = false;
            }
            echo $answerInfo['answerContent']."</li>";
          }
        }
        echo "</ul>";
        if($correctlyAnswered)
        {
          $correctQuestions++;
          echo "<p id='correct'>Correct!</p><br>";
        }
        else
        {
          echo "<p id='incorrect'>INCORRECT!</p><br>";
          $_SESSION['incorrectQuestions'][] = $question[0];
        }
        echo "</td><td width='96px'>";
        echo "<button id='reportButton' onclick='reportButton()'>Report this question</button>";
        echo "</td></tr>";
      }
      $timeDifference = (2 * $correctQuestions) + count($questions);
      echo "</table><br>";
      echo "<button id='closeButton' onclick='self.close()'>Close</button>";
    }
    else if($_SESSION['questionsAccessed'])
    {
      echo "<form method='post'>";
      $questions = $_SESSION['passedQuestions'];
      for($questionCount = 0; $questionCount < count($questions); $questionCount++)
      {
        $question = $questions[$questionCount];
        for($count = 0; $count < count($question); $count++)
        {
          if($count == 0) //value is a question
          {
            $result = $mysqli -> query("SELECT questionContent FROM SB_QUESTIONS WHERE questionID='$question[0]'");
            if($result->num_rows == 1) //this is correct
            {
              $questionInfo = $result->fetch_assoc();
              echo $questionInfo['questionContent']."<br><ul>";
            }
            else //this cannot happen
            {
              echo "ERROR CODE 4386346879346643986376439756346";
            }
          }
          else //value is an answer
          {
            $result = $mysqli -> query("SELECT answerContent FROM SB_ANSWERS WHERE answerID='$question[$count]'");
            $answerInfo = $result->fetch_assoc();
            echo "<li>".$answerInfo['answerContent'];
            $checkbox = "$questionCount,$count";
            echo "<input type='checkbox' name='$checkbox'><br></li>";
          }
        }
        echo "</ul>";
      }
      echo "<input type='submit'value='Submit' name='answered'>";
      echo "</form>";
    }
    else
    {
      $_SESSION['questionsAccessed'] = true;
      //get desired module
      $module = $_GET['module'];
      //get module name
      $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
      $moduleNameRow = $result -> fetch_assoc();
      $moduleName = $moduleNameRow['moduleName'];
      //get module id
      $result = $mysqli -> query("SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
      $moduleIDRow = $result -> fetch_assoc();
      $moduleID = $moduleIDRow['moduleID'];
      //get all questions from module
      $result = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE moduleID='$moduleID'");
      $allQuestions = array();
      while($row = $result->fetch_assoc())
      {
        $allQuestions[] = $row;
      }
      //choose 5 random questions
      $chosenLines = array();
      $numberOfQuestions = 5;
      if($result -> num_rows < $numberOfQuestions)
      {
        $numberOfQuestions = $result -> num_rows;
      }
      while(count($chosenLines) < $numberOfQuestions)
      {
        $randomNumber = rand(1, $result -> num_rows);
        $randomNumber--;
        if(!(in_array($randomNumber, $chosenLines)))
        {
          $chosenLines[] = $randomNumber;
        }
      }
      //get the questions related to each line
      $chosenQuestionsRows = array();
      for($count = 0; $count < $numberOfQuestions; $count++)
      {
        $chosenQuestionsRows[] = $allQuestions[$chosenLines[$count]];
      }
      //create form
      echo "<form method='post'>";
      //display module name
      echo "<h2>".$module.": ".$moduleName."</h2><br><br>";
      echo "<table>";
      //foreach question
      $questionNumber = 0;
      $questionArray = array();
      foreach ($chosenQuestionsRows as $currentRow)
      {
        //get the question
        $question = $currentRow['questionContent'];
        $questionID = $currentRow['questionID'];
        $questionArray[] = array();
        $questionArray[$questionNumber][] = $questionID;

        //display the question
        echo "<tr><td>";
        echo $questionNumber + 1;
        echo ". ".$question;
        echo "<br>";
        //get the answers to the question
        $result = $mysqli -> query("SELECT * FROM SB_ANSWERS WHERE questionID='$questionID'");
        $answers = array();
        while($answerRow = $result->fetch_assoc())
        {
          $answers[] = $answerRow;
        }
        //shuffle the answers
        if(count($answers) > 1)
        {
          $order = array();
          foreach($answers as $key => $answer)
          {
            $order[$key] = ($answer['answerID'] * rand(1, 1000)) % rand(1, 500);
          }
          asort($order);
          $newAnswers = array();
          foreach($order as $key => $orderPosition)
          {
            $newAnswers[] = $answers[$key];
          }
          $answers = $newAnswers;
        }


        echo "<ul>";
        $answerNumber = 0;
        foreach($answers as $answer)
        {
          $answerNumber = $answerNumber + 1;
          echo "<li>"."<input type='checkbox' name='$questionNumber,$answerNumber'>".$answer['answerContent'];
          echo "<br>";
          $questionArray[$questionNumber][] = $answer['answerID'];
        }
        echo "</ul><br>";
        $questionNumber = $questionNumber + 1;
        //display the answers to the question
        echo "</td><td width='98px'>";
        echo "<button id='reportButton' onclick='reportButton()'>Report this question</button>";
        echo "</td></tr>";
      }
      $_SESSION['passedQuestions'] = $questionArray;
      echo "</table><br><br>";
      echo "<input type='submit'value='Submit' name='answered'>";
      echo "</form>";
    }
  ?>

          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
