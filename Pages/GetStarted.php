<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/GetStarted.css">
    <script src="jquery.js"></script>
    <script src="Anchor.js"></script>
    <title>Study Buddy - Get Started</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

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
    <li><span class="link" rel ="#CreateAccount">Create your own account</span></li>
    <li><span class="link" rel ="#LogIn">Log in to your account</span></li>
    <li><span class="link" rel ="#ChangePassword">Change or reset your password</span></li>
    <li><span class="link" rel ="#CreateModule">Create your own module</span></li>
    <li><span class="link" rel ="#SubmitQuestion">Submit your own question</span></li>
    <li><span class="link" rel ="#StartExercise">Start your exercise</span></li>
    <li><span class="link" rel ="#AboutTimer">Learn how the timer works</span></li>
    <li><span class="link" rel ="#ViewQuestions">View the available modules and questions</span></li>
    <li><span class="link" rel ="#ReportModule">Report unsuitable modules</span></li>
    <li><span class="link" rel ="#ReportQuestion">Report unsuitable questions</span></li>
  </ul>

  <div class="help">
    <h3 id="CreateAccount">Create your own account</h3>
    <p>Creating your own <mark>Study Buddy account</mark> is as easy as it gets.<br>To create an account, follow these steps:
    <ol>
      <li>Click the <a href="./Pages/login.php">SIGN UP/LOG IN</a> at the top right corner of the website.</li>
      <li>Enter your name, username, email address and password.</li>
      <li>Click <mark>Sign Up</mark>.</li>
    </ol></p>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

    <h3 id="LogIn">Log in to your account</h3>
    <p>To log in, follow these steps:
    <ol>
      <li>Click the <a href="./Pages/login.php">SIGN UP/LOG IN</a> at the top right corner of the website.</li>
      <li>Enter your <mark>Study Buddy username</mark> and <mark>Password</mark>, then click <mark>Log In</mark>.</li>
      <li>If you don't have a <mark>Study Buddy account</mark>, <span class="link" rel ="#">click here</a> to create one.</li>
    </ol></p>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

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
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

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
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

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
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

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
    </ol>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

    <h3 id="AboutTimer">Learn about the timer</h3>
    <p>Wondering how does the <mark>TIMER</mark> works?<br>
     Users will first set the initial countdown time for the next exercise to appear. Upon completing an exercise, the time of the timer will change in accordance to how well the user did for his/her exercise.<br>
     <mark>For every question the user gets correct, the timer will increase by 30 seconds.<br>
     For every question the user gets wrong, the timer will decrease by 1 minute.</mark><br>
     For example, a user sets the initial countdown time as 8 minutes. The user gets 4 correct and 1 wrong answers for his/her first exercise, so the timer increases by 1 minute. The time for the next exercise to pop-up is now 9 minutes. For the second exercise, he/she gets 2 correct and 3 wrong answers. The timer decreases by 2 minutes, so the time for the next exercise to pop-up is 7 minutes.</p>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

    <h3 id="ViewQuestions">View modules and questions</h3>
    <p>To view the modules and questions currently available for <mark>Study Buddy</mark>:</p>
    <ol>
      <li>Go to the <a href="AllQuestions.php">view questions</a> page.
      <li>Select the module that you want to view the questions.
      <li>If you cannot find the module you want, you can <a href="CreateModule.php">create one</a> here.
      <li>Click the <mark>View Questions</mark> button, and the list of questions for the module you have selected will open in a new window.
      <li>In the new window, you can see the module code, module name, module description and all of the questions available for that module.
      <li>You can choose to <span class="link" rel ="#ReportQuestion">report a question</span>, <span class="link" rel ="#SubmitQuestion">add a question</span> or <span class="link" rel ="#ReportModule">report the module</span> there.
      <li>Click the <mark>Close</mark> button when you are done.
    </ol>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

    <h3 id="ReportModule">Report a module</h3>
    <p>Found a module that is unsuitable for the website? Follow the steps below to report the module:</p>
    <ol>
      <li>Go to the <a href="AllQuestions.php">view questions</a> page and select the module that you want to report.
      <li>Click the <mark>View Questions</mark> button, and the module page will open in a new window.
      <li>Go the the bottom of the page where you can find the <mark>Report this module</mark> button.
      <li>Click the button and the report module page will pop-up.
      <li>Type in the reason of reporting the module at the text area given.
      <li>Click the <mark>Send Report</mark> button once you are done.
      <li>Exit the window by clicking the <mark>Close</mark> button.
    </ol>
    <p>Reporting a module might cause the module and all of its questions to be deleted.<br>
    Only users with a <mark>Study Buddy account</mark> are able to report a module.</p>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>

    <h3 id="ReportQuestion">Report a question</h3>
    <p>Found a question that is unsuitable for the website or is unsuitable for the module it is in? There are two ways to report a question.</p>
    <h4>Through the view questions page</h4>
    <ol>
      <li>Go to the <a href="AllQuestions.php">view questions</a> page and select the module which the question is resided in.
      <li>Click the <mark>View Questions</mark> button, and the module page will open in a new window.
      <li>Next to each questions there is a <mark>Report this question</mark> button.
      <li>Find the question that you want to report and click on the button next to it, and the report question page will pop-up.
      <li>Check the boxes which are applicable for the reasons for you to report the question.
      <li>If the reason is not stated, check the <mark>Other reason(s)</mark> box and type in your own reason at the text area given.
      <li>Once you are done, click the <mark>Send Report</mark> button.
      <li>Exit the window by clicking the <mark>Close</mark> button.
    </ol>
    <h4>Through the exercise page</h4>
    <ol>
      <li>If you discover a faulty question while doing an exercise, you can report it straight away.
      <li>The report button will appear next to the questions after you have submitted the exercise.
      <li>Click the <mark>Report this question</mark> button for the question you want to report, and the report question page will pop-up.
      <li>Check the boxes which are applicable for the reasons for you to report the question.
      <li>If the reason is not stated, check the <mark>Other reason(s)</mark> box and type in your own reason at the text area given.
      <li>Once you are done, click the <mark>Send Report</mark> button.
      <li>Exit the window by clicking the <mark>Close</mark> button.
    </ol>
    <p>Only users with a <mark>Study Buddy account</mark> are able to report a question.</p>
    <br><br><span class="link" rel ="#HowToHelp">Back to top</span>
  </div>

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
