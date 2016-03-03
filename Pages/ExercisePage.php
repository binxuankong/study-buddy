<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/ExercisePage.css">
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
      echo "This executes";
      $_SESSION['incorrectQuestions'] = array();
      $_SESSION['incorrectQuestions'][]=1;
      $_SESSION['incorrectQuestions'][]=2;
      $_SESSION['incorrectQuestions'][]=3;

    }
    if(!(isset($_SESSION['passedQuestions'])))
    {
      $_SESSION['passedQuestions'] = array();
    }
    if(!(empty($_SESSION['questionsAccessed'])))
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
              echo "<p>";
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
          $_SESSION['incorrectQuestions'][] = $question[0]; //This array stores the previosuly incorrect questionS iD
        }
      }
      echo "</p>";
      $timeDifference = (2 * $correctQuestions) + count($questions);
      echo "<br>";
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

      $_SESSION['questionsAccessed'] =true;
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

      $chosenIDs = array();
      $numberOfQuestions = 5;
      if($result -> num_rows < $numberOfQuestions)
      {
        $numberOfQuestions = $result -> num_rows;
      }


      //Get User Rating
      $incorrectQuestions = array();
      $incorrectQuestions = $_SESSION['incorrectQuestions'];
      //Get length of InccorectAnswered Array
      $incorrectQuestionsLength = count($incorrectQuestions);
      //Calculate number of question to come from IncorrectAnswered Array
      if($incorrectQuestionsLength == 0)
      {
        $incorrectQuestionsRequired = 0;

      } else if ($incorrectQuestionsLength > 24)
      {
          $incorrectQuestionsRequired = 5;
      }
      else {
        $incorrectQuestionsRequired = floor($incorrectQuestionsLength / 5) + 1;
      }
      //Chose questions from IncorrectAnswered Array - put in chosen lines



      while(count($chosenIDs) < $incorrectQuestionsRequired)
      {
        $randomNumber = rand(0, $incorrectQuestionsLength -1);



        if(!(in_array($incorrectQuestions[$randomNumber], $chosenIDs)))
        {
          $chosenIDs[]=$incorrectQuestions[$randomNumber];

        }
      }




      $chosenQuestionsRows = array();

      $numRows = 34;
      for($count = 0; $count < $incorrectQuestionsRequired; $count++)
      {
        $currentID = $chosenIDs[$count];
        echo "<br>" . $currentID;
        $result = $mysqli -> query("SELECT * FROM SB_QUESTION WHERE questionID=1 ");

        if($result -> num_rows == 0)
        {
          echo "<br> Shit went wrong";
        }
        while($row = $result->fetch_assoc())
        {
          echo "Thank fuck for that";
          $chosenQuestionsRows[] = $row;
        }


        echo count($chosenQuestionsRows);



      }




      /*
      //Uses this to populate the other questions
      while(count($chosenIDs) < $numberOfQuestions)
      {

        $randomNumber = rand(1, $result -> num_rows);
        $randomNumber--;
        if(!(in_array($randomNumber, $chosenIDs)))
        {
          $chosenLines[] = $randomNumber;
        }
      } */




      //create form
      echo "<form method='post'>";
      //display module name
      echo "<h2>".$module.": ".$moduleName."</h2><br><br>";
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
        echo "<p>";
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
        echo "</ul>";
        $questionNumber = $questionNumber + 1;
        //display the answers to the question
        echo "</br></p>";
      }
      echo "<br><br>";
      echo "<input type='submit'value='Submit' name='answered'>";
      echo "</form>";
      $_SESSION['passedQuestions'] = $questionArray;

      if(is_array($incorrectQuestions))
      {
        echo "Is array";
      }

    }

    function randomNormal($mean, $sd)
    {
      $w = $output1 = $output2;
      do {
          $input1 = 2.0 * mt_rand()/mt_getrandmax() - 1.0;
          $input2 = 2.0 * mt_rand()/mt_getrandmax() - 1.0;

          $w = $input1 * $input1 + $input2 * $input2;

         } while ($w >= 1);


      $w = sqrt( (-2.0 * log($w)) / $w);
      $output1 = $input1 * $w;
      $output2 = $input2 * $w;

      return round(($output1 * $sd + $mean), 0,1);

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
