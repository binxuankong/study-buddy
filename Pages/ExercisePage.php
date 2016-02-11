<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/ExercisePage.css"> 
    <script src="myscript.js"></script>
    <title>Exercise Page</title>
  </head>

  <body onbeforeunload="confirmExit(600000)"> <!-- Change time as input by user from parrent page--> <!-- Change time by score user get-->
<!-- php code here-->
<?php
// Define variables and set to empty values.
$question = $answer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["answer"])) {
  } else {
    $gender = test_input($_POST["answer"]);
  }
}
?>

    <div class="nav">
      <div class="container">
        <ul class="pull-left">
           <a href="../index.html"><img src="../Images/new_logo.png" alt="Studdy Buddy">
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
<!--Get questions and answers from database-->
<form id="frml" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<p>1. The Eiffel Tower is located where in Paris?<br><br>
  (A)<input type="radio" name="answer" value="A">Bois de Boulogne<br>
  (B)<input type="radio" name="answer" value="B">Champ de Mars<br>
  (C)<input type="radio" name="answer" value="C">Jardin des Plantes<br>
  (D)<input type="radio" name="answer" value="D">Parc de Belleville<br>
  <br><br>
  2. Which Apollo mission landed the first humans on the Moon?<br><br>
  (A)<input type="radio" name="answer" value="A">Apollo 7<br>
  (B)<input type="radio" name="answer" value="B">Apollo 9<br>
  (C)<input type="radio" name="answer" value="C">Apollo 11<br>
  (D)<input type="radio" name="answer" value="D">Apollo 13<br>
  <br><br>
  3. Who starred in the 1959 epic film 'Ben-Hur'?<br><br>
  (A)<input type="radio" name="answer" value="A">Charlton Heston<br>
  (B)<input type="radio" name="answer" value="B">Clark Gable<br>
  (C)<input type="radio" name="answer" value="C">Errol Flynn<br>
  (D)<input type="radio" name="answer" value="D">Lee Marvin<br>
  <br><br>
  4. What is the International Air Transport Association airport code for Heathrow Airport?<br><br>
  (A)<input type="radio" name="answer" value="A">HRW<br>
  (B)<input type="radio" name="answer" value="B">HTR<br>
  (C)<input type="radio" name="answer" value="C">LHR<br>
  (D)<input type="radio" name="answer" value="D">LHW<br>
  <br><br>
  5.  The reactor at the site of the Chernobyl nuclear disaster is now in which country?<br><br>
  (A)<input type="radio" name="answer" value="A">Ukraine<br>
  (B)<input type="radio" name="answer" value="B">Slovakia<br>
  (C)<input type="radio" name="answer" value="C">Hungary<br>
  (D)<input type="radio" name="answer" value="D">Russia<br>
  <br><br>
  <input type="submit" name="submit" style="width: 120px" value="Submit">
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
            <h2><img src="../Images/new_logo.png" alt="Studdy Buddy"></img>Study Buddy</h2>
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
            <h3>Solutions</h3>
            <p>Contact us if you encounter any bugs or problems and let us solve your problems.</p>
            <p><a href="Feedback.html">Report a bug</a></p>
          </div>
        </div>
      </div>
    </div>
	
  </body>
</html>
