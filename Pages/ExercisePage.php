<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/ExercisePage.css">
    <script src="./ReportButton.js"></script>
    <script src="./TimerScript.js"></script>
    <title>Study Buddy - Exercise Page</title>
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
    $module = $_GET['module'];//NEED TO PROTECT THIS

    $modulesArrray = array();
    $getID = $mysqli -> prepare("SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID = ?");
    $getID -> bind_param("s", $module);
    $getID -> execute();
    $getID -> store_result();
    $getID -> bind_result($moduleID);
    while( $getID -> fetch())
    {
      $modulesArray[] = $moduleID;
    }

    $moduleID = $modulesArray[0];


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

    if((isset($_SESSION['userID'])))
    {
      $userID = $_SESSION['userID'];
      $getRatingQuery = $mysqli -> query("SELECT userModuleELORating FROM SB_USER_ELO WHERE moduleID='$moduleID' AND userID = '$userID' ");
      $userRatingInfo = $getRatingQuery -> fetch_assoc();
      $userRating = $userRatingInfo['userModuleELORating'];

    }

    else
    {
      $userID = -1;
      $userRating = -1;
    }




    //EXERCISE----------------------------------------------------------------//
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answered'])) //request method POST
    {
      //questions answered
      $_SESSION['questionsAccessed'] = false;


      $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
      $moduleNameRow = $result -> fetch_assoc();
      $moduleName = $moduleNameRow['moduleName'];
      echo "<h2>".$module.": ".$moduleName."</h2><br><br>";
      echo "<h5 id='moduleID' visibility='hidden'>".$module."</h5>";
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
        $getQuestionRating = $mysqli -> query("SELECT questionELORating FROM SB_QUESTIONS WHERE questionID = '$question[0]'");
        $questionRatingInfo = $getQuestionRating -> fetch_assoc();
        $questionRating= $questionRatingInfo['questionELORating'];
        $questionRatingArray[] = $questionRating; //Array of Questions ratings
        if($correctlyAnswered) //Correct Answer
        {
          $correctQuestions++;
          //If previosuly incorrect but now right remove from incorrectQuestions
          if(in_array($question[0], $_SESSION['incorrectQuestions']))
          {
            $newArray = array();
            for ($i=0; $i < count($_SESSION['incorrectQuestions']); $i++)
            {
              if($_SESSION['incorrectQuestions'][$i] != $question[0])
              {
                $newArray[] = $_SESSION['incorrectQuestions'][$i];
              }
            }
            $_SESSION['incorrectQuestions'] = $newArray;

          }

          if($userID != -1)
          {
            $wasCorrect = false;
            $getIfCorrect = $mysqli -> query("SELECT * FROM SB_USER_QUESTION_ATTEMPTS WHERE userID = $userID AND questionID = $question[0]");
            if($getIfCorrect -> num_rows ==1)
            {
              $correctInfo = $getIfCorrect ->fetch_assoc();
              $wasCorrect = true;
            }

            if(!$wasCorrect ) //Wasn't previosuly correct
            {
              //Recalculate Ratings


              $userRating = recalculateRating($userRating, $questionRating, 1);
              $questionRating = recalculateRating($questionRating, $userRating, 0);

              //Add to table
              $addToTable = $mysqli -> query("INSERT INTO SB_USER_QUESTION_ATTEMPTS (UserID, QuestionID) VALUES ($userID, $question[0])");
            }
          }
          echo "<p id='correct'>CORRECT!</p><br>";
          echo "</td><td width='96px'>";
          echo "<button id='".$question[0]."' onclick='reportQuestion(this.id)'>Report this question</button>";
          echo "</td></tr>";
        }

        else //Answered incorrectly
        {

          if($userID != -1 && $userRating != 0)
          {


            $userRating = recalculateRating($userRating, $questionRating, 0);
            $questionRating = recalculateRating($questionRating, $userRating, 1);


            $mysqli -> query("UPDATE SB_USER_ELO SET userModuleELORating = $userRating WHERE userID = $userID AND moduleID = $moduleID");


            $mysqli -> query("UPDATE SB_QUESTIONS SET questionELORating = $questionRating WHERE questionID = $question[0]");

          }
        echo "<p id='incorrect'>INCORRECT!</p><br>";
        $_SESSION['incorrectQuestions'][] = $question[0]; //This array stores the previosuly incorrect questionS iD
        echo "</td><td width='96px'>";
        echo "<button id='".$question[0]."' onclick='reportQuestion(this.id)'>Report this question</button>";
        echo "</td></tr>";
        }
      }//for
      if($userID != -1 && $userRating == 0) //Calculate intial rating, new user
      {

        $averageRating = array_sum($questionRatingArray)
                        / count($questionRatingArray);

        $addedFactor = $correctlyAnswered - 3;

        $newRating = round($averageRating,0,1) + 40 * $addedFactor;

        if($mysqli -> query("INSERT INTO SB_USER_ELO VALUES ($userID, $moduleID, $newRating)")===true)
        {
          echo "New User Rating added: ". $newRating;
        }


      }

      echo "</p>";
      $timeDifference = (2 * $correctQuestions) + count($questions);
      echo "</table><br>";
      echo "<button id='closeButton' onclick='resetTimer();'>Close</button>";

     // Update the user quality of user.
      if($userID != -1)
      {
        $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$userID'");
        $userQuestionQualityRow = $result -> fetch_assoc();
        $userQuestionQuality = $userQuestionQualityRow['userQuestionQuality'];
        $userQuestionQuality = $userQuestionQuality + 1;
        if ($userQuestionQuality > 500)
        {
          $userQuestionQuality = 500;
        }
        $updateUserQuality = "UPDATE SB_USER_INFO SET userQuestionQuality='$userQuestionQuality' WHERE userID='$userID'";
        $mysqli->query($updateUserQuality);
      }

      $_SESSION['passedQuestions'] = array();
    }
    else if($_SESSION['questionsAccessed'])
    {
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
      echo "<form method='post'>";
      echo "<h2>".$module.": ".$moduleName."</h2><br><br>";
      echo "<table>";
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
              echo "<tr><td>";
              echo $questionCount + 1;
              echo ". ".$questionInfo['questionContent']."<br>";
              echo "<ul>";
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
            $checkbox = "$questionCount,$count";
            echo "<li><input type='checkbox' name='$checkbox'>";

            echo $answerInfo['answerContent']."</li>";
          }
        }
        echo "</ul><br>";
        echo "</td>";
      }
      echo "</table><br><br>";
      echo "<input type='submit'value='Submit' name='answered'>";
      echo "</form>";
    }
    else
    {
      $_SESSION['questionsAccessed'] = true;
      //Prodcues all the questions
      //get desired module
      $module = $_GET['module']; //Injection proof this GET
      //get module name
      $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
      $moduleNameRow = $result -> fetch_assoc();
      $moduleName = $moduleNameRow['moduleName'];
      //get module id

      //get all questions from module
      $allQuestions = array();
      if($userID == -1 || $userRating == 0)
      {

        $result = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE moduleID='$moduleID' AND questionRisk<100");


        while($row = $result->fetch_assoc())
        {
          $allQuestions[] = $row;

        }
        
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

      //Adds the questions info for incorrectQuestions array to chosenQuestionsRows array
      for($count = 0; $count < $incorrectQuestionsRequired; $count++)
      {
        $currentID = $chosenIDs[$count];
        $thisQuestion = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE questionID=$currentID");

        while($row = $thisQuestion->fetch_assoc())
        {
          $chosenQuestionsRows[] = $row;
        }
      }


      //Uses this to populate the other questions
      $chosenLines = array();

      if($userID == -1 || $userRating == 0) //Random population of questions if not logged in
      {
        while( count($chosenLines)< ($numberOfQuestions -count($chosenIDs)) )
        {

          $randomNumber = rand(1, $result -> num_rows);
          $randomNumber--;
          if(!(in_array($randomNumber, $chosenLines)))
          {
            $chosenLines[] = $randomNumber;
          }
        }

        for ($count=0; $count < count($chosenLines) ; $count++)
        {

          $chosenQuestionsRows[] = $allQuestions[$chosenLines[$count]];
        }
      }
      else //User logged in.
      {
        while(count($chosenQuestionsRows) < 5) //questions still need to be added
        {
          $rating = randomNormal($userRating,100);
          $upperRating = $rating + 20;
          $lowerRating = $rating - 20;

          $getQuestions = $mysqli -> query("SELECT * FROM SB_QUESTIONS WHERE $userRating < $upperRating AND $userRating > $lowerRating");
          $randomQuestion = $getQuestions -> fetch_assoc();

          if($randomQuestion -> num_rows != 0) //Checks questions in this range
          {
            if($randomQuestion -> num_rows == 1) // Only one question so add it
            {
              $chosenQuestionsRows[] = $randomQuestion[0];
            }
            else //Chose question at random and select it.
            {
              $randomNumber = rand(1, $randomQuestion -> num_rows);
              $randomNumber--;

              $chosenQuestionsRows[] = $randomQuestion[$randomNumber];
            }
          }

        }//while
      }//else

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
        echo "</td>";
      }
      $_SESSION['passedQuestions'] = $questionArray;
      echo "</table>";
      echo "<br><br>";
      echo "<input type='submit'value='Submit' name='answered'>";
      echo "</form>";
      $_SESSION['passedQuestions'] = $questionArray;

    }

    function randomNormal($mean, $sd)
    {
      $w = $output1 = $output2 = 0;
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

    function recalculateRating($initialRating, $relativeRating, $score)
    {
      //initialRating will be changed relative to relativeRating and the score
      //score being 1 if question is correct and 0 if question was wrong


      $expectedScore = 1/(1+pow(10,(($relativeRating - $initialRating)/400)));
      $kFactor = calculateKFactor($initialRating);

      $newRating = (int)$initialRating + $kFactor * ($score - $expectedScore);

      return round($newRating,0,1);


    }

    function calculateKFactor($rating)
    {
      if($rating <2100)
      {
        return 32;
      }else if ($rating < 2400) {
        return 24;
      } else if ($rating < 2600) {
        return 16;
      } else {
        return 10;
      }
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
