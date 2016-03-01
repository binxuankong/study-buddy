<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <script> 
      $(function(){
        $("#header").load("header.html"); 
        $("#footer").load("footer.html"); 
      });
    </script>
    <title>Submit Question</title>
  </head>

  <body>
    <?php
      $question = $moduleCourseID = $answer = "";
      $questionErr = $answerErr = $moduleErr = "";
      $correctAnswer = 0;
      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {
        echo "<h1>POSTED</h1>";
        //Checks there exists a question
        if (empty($_POST['question']))
        {
          $questionErr = "Please input a question";
        }
        else
        {
          $question = test_input($_POST['question']); //Sets question variable
        }

        if(empty($_POST['ans1']) or empty($_POST['ans2'])) //Checks at least 2 answers
        {
          $answerErr = " Please input at least 2 answers";
        }

        if(empty($_POST['correctAnswer'])) // At least one check box is checked
        {
          $answerErr = "Please check at least one answer to be correct";
        }

        if($answerErr="" and $questionErr="") //no errors
        {
          //opening databases connection
          require_once('../config.inc.php');
          $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
          if($mysqli -> connect_error)
          {
            die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
          }

          //Get module ID for corresponding module code
          $getModuleID = "SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID ='" . $code . "'";
          $result = $mysqli -> query($getModuleID);

          $moduleIDRow = $result -> fetch_assoc();
          $moduleID = $moduleIDRow['moduleID'];

          //Add question to question table with that module ID
          $insertQuestion =" INSERT INTO SB_QUESTIONS (moduleID, questionContent)"
                           ."VALUES ('" .$moduleID. "', '" . $question . "')";
          $mysqli -> query($insertQuestion);

          //Get new question ID
          $getModuleID = "SELECT questionID FROM SB_QUESTIONS WHERE questionContent ='" . $question . "'";
          $result = $mysqli -> query($getModuleID);

          $questionIDRow = $result -> fetch_assoc();
          $questionID = $moduleIDRow['questionID'];

          //Add all answers to answer table with new question ID
            //Check if box empty
            for($count = 1; $count<=5; $count++)
            {
              if(!(empty($_POST["ans".$count]))) //Check if it's a correct answer
              {
                $answerCorrect = 1;
                if(empty($_POST["correctAnswer".$count]))
                {
                  $answerCorrect = 0;
                }
                $currentAnswer = $_POST["ans".$count];
                $insertAnswer = " INSERT INTO SB_ANSWERS(questionID, answerContent, answerCorrect)"
                                ."VALUES ('" . $questionID . "', '" . $currentAnswer . "', '" . $answerCorrect . "')";
                $mysqli -> query($insertAnswer);
              }
            }

        }



      }//First IF
      require_once('../config.inc.php');
      $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
      if($mysqli -> connect_error)
      {
        die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
      }

      function test_input($data) 
      {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    ?>
    <div id="header"></div>

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
            <?php
              require_once('../config.inc.php');
              $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
              if($mysqli -> connect_error)
              {
                die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
              }
              $result = $mysqli -> query("SELECT moduleCourseID FROM SB_MODULE_INFO");
              echo '<br><p>Choose a module to add a question to</p><select id="moduleDropdown" name="module">';
              echo "<option value='Choose a module'>Choose a module</option>";
              while($row = $result->fetch_assoc())
              {
                $thismodule = $row["moduleCourseID"];

                echo "<option value='$thismodule'>$thismodule</option>";
              }
              echo '</select><br><h3 id="errorLabel" class="error"></h3>';
              $mysqli -> close();
            ?>
           <form method="post">
           <p>
             <br>
             Enter the question:
             <br>
             <textarea name="question" rows="3" cols="80" required>
             </textarea>
             <br><br>
             Enter up to 5 Answers for this question:
             <br>
             (check any answers that are correct)
             <br>

             1. <input type="text" name="ans1" size="64">
                <input type="checkbox" name="correctanswer1" ><br>

             2. <input type="text" name="ans2" size="64">
                <input type="checkbox" name="correctanswer2"><br>

             3. <input type="text" name="ans3" size="64">
                <input type="checkbox" name="correctanswer3"><br>

             4. <input type="text" name="ans4" size="64">
                <input type="checkbox" name="correctanswer4"><br>

             5. <input type="text" name="ans5" size="64">
                <input type="checkbox" name="correctanswer5"><br>

             <br><br>
             <input type="submit" value="Submit Question">
           </form>

            </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

    <div id="footer"></div>

  </body>
</html>
