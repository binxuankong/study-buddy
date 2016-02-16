<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="myscript.js"></script>
    <title>Exercise Page</title>
  </head>

  <!-- Javascript code for popup-->
  <body onbeforeunload="confirmExit(600000)">
  <!-- Change time as input by user from parrent page--> <!-- Change time by score user get-->

<!-- PHP code here-->
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$rightAnswer = 0;
$wrongAnswer = 0;

require_once('exercise.php');
require_once('randomizer.php');

if (isset($_POST['submit'])){
  foreach($_POST['response'] as $key => $value){
      if($correctAnswerArray[$key] == $value){
          $rightAnswer++;
      } else {
          $wrongAnswer++;
      }
  }
}
?>

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

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

<!--Display form-->
<form action="ExercisePage.php" method="post">

  <?php
    foreach($questions as $id => $question) {
      echo "<div class=\"form-group\">";
      //Display the question.
      echo "<p> $question</p>"."<ol>";

        //Display multiple choices
        $randomChoices = $choices[$id];
        $randomChoices = shuffle_assoc($randomChoices);
        foreach ($randomChoices as $key => $values){
            echo '<li><input type="checkbox" name="response['.$id.'] id="'.$id.'" value="' .$values.'"/>';
  ?>
  
  <label for="question-<?php echo($id); ?>"><?php echo($values);?></label></li>

  <?php
        }
            echo("</ul>");
            echo("</div>");
        }
  ?>

    <input type="submit" name="submit" class="btn btn-primary" value="Submit Exercise" />
</form>
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
            <p>Contact us if you encounter any bugs or problems and let us solve your problems.</p>
            <p><a href="Feedback.html">Report a bug</a></p>
          </div>
        </div>
      </div>
    </div>
	
  </body>
</html>