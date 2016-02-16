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
        <h1>Submit a Question</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
	      
         <form action="">
         <p>
           Enter the Module for this question:
           <select name="module">
           </select>

           <br>
           Enter the question:
           <br>
           <textarea name="question" rows="3" cols="80">
           </textarea>
           <br>
	        
           Enter up to 5 Answers for this question:
           <br>
           (check any answers that are correct)
           <br>
	        
           1. <input type="text" name="ans1" size="64"> 
              <input type="checkbox" name="correctanswer"><br>
           2. <input type="text" name="ans2" size="64"> 
              <input type="checkbox" name="correctanswer"><br>
           3. <input type="text" name="ans3" size="64"> 
              <input type="checkbox" name="correctanswer"><br>
           4. <input type="text" name="ans4" size="64"> 
              <input type="checkbox" name="correctanswer"><br>
           5. <input type="text" name="ans5" size="64"> 
              <input type="checkbox" name="correctanswer"><br>
           <br><br>
           <input type="submit" value="Submit Question">
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