<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/AllQuestions.css">
    <script src="./ViewQuestions.js"></script>
    <script src="jquery.js"></script>
    <script> 
      $(function(){
        $("#header").load("header.html"); 
        $("#footer").load("footer.html"); 
      });
    </script>
    <title>View All Questions</title>
  </head>

  <body onload="displayTime()">
    <div id="header"></div>
  
    <div class="heading">
      <div class="container">
        <h1>View All Questions</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

    <?php
      require_once('../config.inc.php');
      $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
      if($mysqli -> connect_error) 
      {
        die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
      }

        $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO");
        echo "<br><p>Choose a module to view all the questions available for this module</p><br><select id='moduleDropdown' name='module'>";
        echo "<option value='Choose a module'>Choose a module</option>";
        while($row = $result->fetch_assoc())
        {
          $thismodule = $row["moduleCourseID"];
          
          echo "<option value='$thismodule'>$thismodule</option>";
        }
      echo '</select><p id="errorLabel" class="error"></p>';
      $mysqli -> close();
    ?>

    <button id="viewQuestions" onclick="clickButton();">View Questions</button>

    <p>Can't find the module you want?</p>
    <a href="CreateModule.php">Create your own module here</a>

          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

    <div id="footer"></div>

  </body>
</html>
