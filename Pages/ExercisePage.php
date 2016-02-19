<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="TimerScript.js"></script>
    <title>Exercise Page</title>
  </head>

  <!-- Javascript code for popup-->
  <body onbeforeunload="confirmExit(600000)">
  <!-- Change time as input by user from parrent page--> <!-- Change time by score user get-->
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
<!-- PHP code here-->
<?php
//IGNORE THIS FOR NOW---------------------------------------------------------//
#error_reporting(E_ALL);
#ini_set('display_errors', 1);
// $rightAnswer = 0;
// $wrongAnswer = 0;
//IMPORTS---------------------------------------------------------------------//
//import database credentials
require_once('../config.inc.php');
//import randomizer
require_once('randomizer.php');
//DATABASE CONNECTION---------------------------------------------------------//
//create database connection
$mysqli = new mysqli($database_host, $database_user,
                     $database_pass, $database_name);

//check for connection errors kill page if found
if($mysqli -> connect_error) 
{
  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
}
//EXERCISE--------------------------------------------------------------------//
//get desired module
$module = $_get['module'];
$result = $mysqli -> query("SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
$moduleIDRow = $result -> fetch_assoc();
$moduleID = $modueIdRow['moduleID'];
//get all questions from module
$result = $mysqli -> query("SELECT questionID FROM SB_QUESTION_INFO WHERE moduleID='$moduleID'");
$allQuestions = array();
while($allQuestions[] = $result->fetch_assoc()){}
//choose 5 random questions
$num_questions_returned = $result->num_rows;
$numberOfQuestions = 5;
$chosenLines = array();
while (count($chosenLines) < $numberOfQuestions) {
    $random = rand(1, $num_questions_returned);
    if (!in_array($random, $chosenLines)) {
        $chosenLines[] = $random;
    }
}
//get the questions related to each line
$chosenQuestionsRows = {$allQuestions[$chosenLines[0]],
                        $allQuestions[$chosenLines[1]],
                        $allQuestions[$chosenLines[2]],
                        $allQuestions[$chosenLines[3]],
                        $allQuestions[$chosenLines[4]]};
//create form
echo "<form>";
<?php
//foreach question
foreach($chosenQuestionRows as $question) {
  //display the question
    echo "<div class=\"form-group\">";
    echo "<p>$question</p>"."<ol>";
  //get the answers to the question
    $answersResult = $mysqli -> query("SELECT * FROM SB_ANSWERS WHERE questionID = $question['questionID']");
    $choices = array();
    while ($row = $answersResult->fetch_assoc()) {
        $choices[] = $row;
    }
  //display the answers to the question
    $randomChoices = shuffle_assoc($randomChoices);
    foreach ($randomChoices as $key => $values){
        echo '<li><input type="checkbox" name="response['.$id.'] id="'.$id.'" value="' .$values.'"/>';
  //store the answers to the question (hidden form element)
}
?>

  <label for="question-<?php echo($id); ?>"><?php echo($values);?></label></li>

<?php
    }
        echo("</ul>");
        echo("</div>");
    }
?>
  <input type="submit" name="submit" class="btn btn-primary" value="Submit Exercise" />
echo "</form>";
//END SCRIPT!
?>


    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

<!--Display form-->
<!--IGNORE THIS CODE FOR NOW
#<form action="ExercisePage.php" method="post">

#  <?php
#    foreach($questions as $id => $question) {
#      echo "<div class=\"form-group\">";
#      //Display the question.
#      echo "<p>$question</p>"."<ol>";

#        //Display multiple choices
#        $randomChoices = $choices[$id];
#        $randomChoices = shuffle_assoc($randomChoices);
#        foreach ($randomChoices as $key => $values){
#            echo '<li><input type="checkbox" name="response['.$id.'] id="'.$id.'" value="' .$values.'"/>';
#  ?>
#  
#  <label for="question-<?php echo($id); ?>"><?php echo($values);?></label></li>

#  <?php
#        }
#            echo("</ul>");
#            echo("</div>");
#        }
#  ?>
#    <input type="submit" name="submit" class="btn btn-primary" value="Submit Exercise" />
#</form>
#          </div>
-->
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