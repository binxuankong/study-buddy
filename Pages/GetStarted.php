<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/GetStarted.css">
    <script src="jquery.js"></script>
    <script src="Anchor.js"></script>
    <script> 
      $(function(){
        $("#header").load("header.html"); 
        $("#footer").load("footer.html"); 
      });
    </script>

    <title>Get Started</title>
  </head>

  <body>
    <div id="header"></div>

    <div class="heading">
      <div class="container">
        <h1>Get Started</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

  <h2>What is Study Buddy?</h2><br>
  <p>Study Buddy is a web application created by the M3 Group of the School of Computer Science from the University of Manchester for the COMP10120 first-year team project. The purpose of this application is to help the users be aware of their procrastination.</p><br><br>

  <h2>How does Study Buddy work?</h2><br>
  <p>The users can submit their own course modules and questions to the web application. The users can then choose the module that they want to revise by going to the <a href="Timer.php">Start timer</a> page and click the <mark>START</mark> button. When the button is clicked, the timer will run, and upon reaching zero, the exercise page for the selected module will pop-up. The users are then required to complete and submit the exercise. The exercise page will then be marked, and the time of the timer will change according to how well the user did for his/her exercise. For every question the user gets correct, the timer will increase by a few seconds. However, for every question the user gets incorrect, the timer will decrease by a larger amount of seconds. The timer automatically resets itself when the exercise is submitted, and different exercises will continue popping-up until the user presses the <mark>STOP</mark> button.</p><br><br>

  <h2 id="HowToHelp">How can we help you?</h2><br>
  <ul id="index">
    <li><a href="#CreateAccount">Create your own account</a></li>
    <li><a href="#LogIn">Log into your account</a></li>
    <li><a href="#ChangePassword">Change or reset your password</a></li>
    <li><a href="#CreateModule">Create your own module</a></li>
    <li><a href="#SubmitQuestion">Submit your own question</a></li>
    <li><a href="#StartExercise">Start your exercise</a></li>
    <li><a href="">Learn how the timer works</a></li>
    <li><a href="">View the available modules and questions</a></li>
    <li><a href="">Report unsuitable questions</a></li>
    <li><a href="">Learn how the questions are picked for you</a></li>
  </ul>

  <div class="help">
    <h3 id="CreateAccount">Create your own account</h3>
    <p>Creating your own <mark>Study Buddy account</mark> is as easy as it gets.<br>To create an account, follow these steps:
    <ol>
      <li>Click the <a href="#">SIGN UP/LOG IN</a> at the top right corner of the website.</li>
      <li>Enter your username, email address and password.</li>
      <li>Click <mark>Sign Up</mark>.</li>
    </ol></p>
    <br><br><a href="#HowToHelp">Back to top</a>

    <h3 id="LogIn">Log into your account</h3>
    <p>To log in, follow these steps:
    <ol>
      <li>Click the <a href="#">SIGN UP/LOG IN</a> at the top right corner of the website.</li>
      <li>Enter your <mark>Study Buddy username</mark> and <mark>Password</mark>, then click <mark>Log In</mark>.</li>
      <li>If you don't have a <mark>Study Buddy account</mark>, <a href="#">click here</a> to create one.</li>
    </ol></p>
    <br><br><a href="#HowToHelp">Back to top</a>

    <h3 id="ChangePassword">Change or reset your password</h3>
    <p>Changing your password regularly is a good idea. It is easy to do so.<br>Or maybe you've forgotten your password. Don't worry, it's easy to reset too.
    <h4>Change your password</h4>
    <ol>
      <li>Go to the <a href="#">password change</a> page.</li>
      <li>Enter your current password in <mark>Current password</mark>.</li>
      <li>Enter your new password in <mark>New password</mark>.</li>
      <li>Enter your new password in <mark>Repeat new password</mark>.</li>
      <li>Click <mark>Set New Password</mark>.</li>
    </ol>
    <h4>Reset your password</h4>
    <ol>
      <li>Go to the <a href="#">password reset</a> page.</li>
      <li>Enter your username and email address.</li>
      <li>Click <mark>Reset Password</mark>.</li>
      <li>Check your email inbox for an email from us with the subject "Reset your password".</li>
      <li>Click the link in the e-mail.</li>
      <li>Enter your new password in <mark>New password</mark>.</li>
      <li>Enter your new password again in <mark>Repeat new password</mark>.</li>
      <li>Click <mark>Set New Password</mark>.</li>
    </ol></p>
    <br><br><a href="#HowToHelp">Back to top</a>

    <h3 id="CreateModule">Create your own module</h3>
    <p>To create your own module to revise on, follow these steps:</p>
    <ol>
      <li>Go to the <a href="CreateModule.php">Create a module</a> page.</li>
      <li>Enter the code of the module at the <mark>Module Code</mark> section.</li>
      <li>Enter the name of the module at the <mark>Module Name</mark> section.</li>
      <li>Enter the description of the module at the <mark>Module Description</mark> section.</li>
      <li>Click <mark>Submit Module</mark>.</li>
      <li>To avoid any conflict, first check whether the module you want to create exists before submitting.</li>
    </ol>
    <p>Only users with a <mark>Study Buddy account</mark> are able to create a module.</p>
    <br><br><a href="#HowToHelp">Back to top</a>

    <h3 id="SubmitQuestion">Submit your own question</h3>
    <p>To create your own question for a module, follow these steps:</p>
    <ol>
      <li>Go to the <a href="SubmitQuestion.php">Submit a question</a> page.</li>
      <li>Choose the module for the question to be added into.</li>
      <li>If you cannot find the module you want, you can <a href="CreateModule.php">create a module</a> here.
      <li>Enter the question.</li>
      <li>Enter the choices for the question, up to a maximum of 5 choices.</li>
      <li>Check the checkboxes for all the correct answers for the question.</li>
      <li>Click <mark>Submit Question</mark>.</li>
      <li>You can view your question at the <a href="AllQuestions.php">View questions</a> page.</li>
    </ol>
    <p>Only users with a <mark>Study Buddy account</mark> are able to submit a question.</p>
    <br><br><a href="#HowToHelp">Back to top</a>

  <h3 id="StartExercise">Start your exercise</h3>
  <p>Feeling productive and want to do some revision? Study Buddy is an easy way to help keep your brain active.<br> To start your revision, follow these simple steps:</p>
  <ol>
    <li>Click the <mark>START NOW</mark> button at the homepage or go to the <a href="Timer.php">Start timer</a> page.</li>
    <li>Pick the module that you want to revise.</li>
    <li>Click the <mark>+</mark> or <mark>-</mark> button to increase or decrease the initial time of the timer.</li>
    <li>Click <mark>START</mark> and the timer will run.</li>
    <li>Wait for the timer to go down to the time until the next exercise.</li>
    <li>Sit back and relax. When the timer reaches 0, the exercise page will pop-up.</li>
    <li>When the exercise page pop-up, solve all the questions.</li>
    <li>Click <mark>Submit</mark> when you're done.</li>
    <li>Click <mark>Close</mark> to exit the exercise page, and wait for the next exercise page to pop-up.</li>
    <li>To stop the revision, click <mark>STOP</mark> to end the timer.</li>
  </ol></p>
    <br><br><a href="#HowToHelp">Back to top</a>
  </div>

          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

    <div id="footer"></div>
	
  </body>
</html>
