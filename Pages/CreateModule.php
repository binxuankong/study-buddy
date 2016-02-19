<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <title>Create Module</title>
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

        <h1>Create a Module</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

            <?php    
        if(isset($_POST['SubmitButton'])){ //check if form was submitted
          $input = $_POST['inputText']; //get input text
          echo "Success! You entered: ".$input;
        }  ?>
	      
        <form action="">
	<p>         
          Module Code:
          <input type="text" name="code" placeholder="e.g. COMP16121">
          <br><br>
          Module Name:
          <input type="text" name="name" size="50"
          value="e.g. Object Orientated Programming with Java">
          <br><br>
          Module Description:<br>
          <textarea name="description" placeholder="e.g. First Year Java Course for Computer Science" 
          rows="4" cols="63"></textarea>
          <br><br><br>
          <input type="submit" value="Submit Module">
        </p>
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
            <p>Contact us if you encounter any problems or if you have any suggestions to improve our website and let us solve your problems.</p>
            <p><a href="Feedback.html">Send a feedback</a></p>
          </div>
        </div>
      </div>
    </div>
	
  </body>
</html>
