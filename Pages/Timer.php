<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Timer.css">
    <script src="./TimerScript.js"></script>
    <title>Template</title>
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
    
    <div class="heading">
      <div class="container">
        <h1>Timer</h1>
      </div>
    </div>
    <div id="timer-div" class="centered">
      <?php
        require_once('../config.inc.php');
        $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
        if($mysqli -> connect_error) 
        {
          die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
        }
        $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO WHERE 1=1");
        echo '<br>Choose a module to revise<br><select id="moduleDropdown" name="module">';
        echo "<option></option>";
        while($row = $result->fetch_assoc())
        {
          $thismodule = $row["moduleCourseID"];
          
          echo "<option value='$thismodule'>$thismodule</option>";
        }
        echo '</select><br>';
        $mysqli -> close();
      ?>
      <div>
        Set an initial time
        <div class="rounded" >
          <table width="100%">
            <tr>
              <td width="10%"></td>
              <td id="time" width="80%">10:00</td>
              <td width="10%"><table>
                <tr><td onclick="increaseTime();">+</td></tr>
                <tr><td onclick="decreaseTime();">-</td></tr>  
              </table></td>
            </tr>
          </table>
        </div>
      </div>
      <div>
      </div>
      <br>
	    <button id="Start-Stop" onclick="clickButton(3000);">Start</button
	  </div>
	  
    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
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
            <h3>Feedback</h3>
            <p>Contact us if you encounter any bugs or problems and let us solve your problems.</p>
            <p><a href="Feedback.html">Report a bug</a></p>
          </div>
        </div>
      </div>
    </div>
	
  </body>
</html>
