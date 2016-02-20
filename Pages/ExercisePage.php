<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <title>Exercise Page</title>
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
        <h1>Exercise</h1>
      </div>
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
              echo $questionInfo['questionContent']."<br><ul>";
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
            echo "<li>".$answerInfo['answerContent'];
            $checkbox = "$questionCount,$count";
            if(isset($_POST[$checkbox]))
            {
              echo "<input type='checkbox' name='$checkbox' disabled checked><br></li>";
            }
            else
            {
              echo "<input type='checkbox' name='$checkbox' disabled><br></li>";
            }
            if(($answerInfo['answerCorrect'] != 0) Xor (isset($_POST[$checkbox]))) //user answered incorrectly
            {
              $correctlyAnswered = false;
            }
          }
        }
        echo "</ul>";
        if($correctlyAnswered)
        {
          $correctQuestions++;
          echo "CORRECT! <br>";
        }
        else
        {
          echo "Incorrect <br>";
          $_SESSION['incorrectQuestions'][] = $question[0];
        }
      }
      $timeDifference = (2 * $correctQuestions) + count($questions);
      echo "<button id='closeButton' onclick=''>Close</button>";
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
      $_SESSION['questionsAccessed'];
      //get desired module
      $module = $_GET['module'];
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
        echo $question;
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
          echo "<li>".$answer['answerContent']."<input type='checkbox' name='$questionNumber,$answerNumber'>";
          echo "<br>";
          $questionArray[$questionNumber][] = $answer['answerID'];
        }
        echo "</ul>";
        $questionNumber = $questionNumber + 1;
        //display the answers to the question
      }
      $_SESSION['passedQuestions'] = $questionArray;
      echo "<input type='submit'value='Submit' name='answered'>"; 
      echo "</form>";
    }
  ?>
    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
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