<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Timer.css">
    <script src="./TimerScript.js"></script>
    <script src="jquery.js"></script>
    <title>Study Buddy - Set Timer</title>
  </head>

  <body  onload="displayTime();">
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>
  
    <div class="heading">
      <div class="container">
        <h1>Timer</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
            <div id="timer-div" class="centered">
              <?php
                require_once('../config.inc.php');
                $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
                if($mysqli -> connect_error) 
                {
                  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
                }
                $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO ORDER BY moduleCourseID ASC");
                echo '<br><h5 id="chooseAModuleLabel">Choose a module to revise </h5>'
                     ."<span class='dropt'><img src='../Images/information.png'>"
                     ."<span style='width:500px;'>Select the module that you want to revise.<br>You can view the questions available for the module in the <b>View All Questions</b> page.<br>If you cannot find the module you want, you can create one in the <b>Create a Module</b> page and add questions to the module created in the <b>Submit a Question</b> page.</span></span>"
                     .'<br><select id="moduleDropdown" name="module">';
                echo "<option value='Choose a module'>Choose a module</option>";
                while($row = $result->fetch_assoc())
                {
                  $thismodule = $row["moduleCourseID"];
                  echo "<option value='$thismodule'>$thismodule</option>";
                }
                echo '</select><br><h3 id="errorLabel" class="error"></h3>';
                $mysqli -> close();

              ?>
              <div class="setTime">
                <h5 id="initialTimeLabel">Set an initial time</h5>
                <span class='dropt'><img src='../Images/information.png'>
                <span style='width:500px;'>The initial time of the timer.<br>When the timer reaches 0, the exercise page will pop-up.<br>When the exercise is completed, the timer will change according to how well you performed in the exercise, and will automatically run again.<br>The <b>+</b> button will increase the initial time of the timer by 30 seconds.</br>The <b>-</b> button will decrease the initial time of the timer by 30 seconds.<br>Click the <b>Start Timer</b> button to start the timer.</span></span><br>
                <div class="rounded" >
                  <table id="timerBox">
                    <tr>
                      <td width="10%"></td>
                      <td id="time" width="80%">Something has gone wrong</td>
                      <td width="10%"><table>
                        <tr><td onclick="increaseTime();"><img src="../Images/plus.png"</img></td></tr>
                        <tr><td onclick="decreaseTime();"><img src="../Images/minus.png"</img></td></tr>  
                      </table></td>
                    </tr>
                  </table>
                </div>
              </div><br>
	            <button id="Start-Stop" onclick="clickButton();">Start Timer</button>
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
