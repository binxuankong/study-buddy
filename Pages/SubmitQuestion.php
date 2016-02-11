<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css"> 
    <title>Submit Question</title>
  </head>

  <body>
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

    <div class="jumbotron">
      <div class="container">
	      
	      <h2> Submit a Question </h2>
	      
	      <form action="">
	        Enter the Module for this question:
	        <select name="module">
	        </select> 
	        
	        
	        Enter the question:
	        <br>
	        <textarea name="question" rows="5" cols="50">
	        </textarea>
	        <br>
	        
	        Enter up to 5 Answers for this question:
	        <br>
	        (check any answers that are correct)
	        <br>
	        
	        1. <input type="text" name="ans1"> 
	           <input type="checkbox" name="correctanswer"><br>
	        2. <input type="text" name="ans2"> 
	           <input type="checkbox" name="correctanswer"><br>
	        3. <input type="text" name="ans3"> 
	           <input type="checkbox" name="correctanswer"><br>
          4. <input type="text" name="ans4"> 
	           <input type="checkbox" name="correctanswer"><br>
	        5. <input type="text" name="ans5"> 
	           <input type="checkbox" name="correctanswer"><br><br>
	        
	        <input type="submit" value="Submit Question">
	       </form>
	         
	      
	      
	      
	      


	
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