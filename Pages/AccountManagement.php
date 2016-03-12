<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Account Management</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Account Management</h1>
      </div>
    </div>
	      
    <div class="body">
      <div class="container">
        <?php
          if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
          {
            require_once('../config.inc.php');
            $mysqli = new mysqli($database_host, $database_user,
                                     $database_pass, $database_name);              

            if($mysqli -> connect_error) 
            {
              die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
            } 
            // Parameterise SQL statement.
            $result = array();
            $resultRow = array();
            $sql = $mysqli -> prepare("SELECT * FROM SB_USER_INFO WHERE userID=?");
            $sql -> bind_param("s", $_SESSION['userID']);
            $sql -> execute();
            $sql -> store_result();
            $sql -> bind_result($fetchedUserID, $fetchedUserScreenName, 
                                $fetchedFirstName, $fetchedSurname, 
                                $fetchedEmail, $fetchedUserQQ);
            while($sql -> fetch())
            {
              $resultRow['userID'] = $fetchedUserID;
              $resultRow['screenName'] = $fetchedUserScreenName;
              $resultRow['firstName'] = $fetchedFirstName;
              $resultRow['surname'] = $fetchedSurname;
              $resultRow['email'] = $fetchedEmail;
              $resultRow['userQQ'] = $fetchedUserQQ;
              $result[] = $resultRow;
            }
            $sql -> close(); 
            echo "<div>";
            echo "Account details";
            echo "<table>";
              echo "<tr>";
                echo "<td>Username</td>";
                echo "<td>".$result[0]['screenName']."</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>Name</td>";
                echo "<td>".$result[0]['firstName']." ".$result[0]['surname']."</td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>Email address</td>";
                echo "<td>".$result[0]['email']."</td>";
              echo "</tr>";
            echo "</table>";
            echo "</div>";
            
            $result1 = array();
            $result1Row = array();
            $sql = $mysqli -> prepare("SELECT * FROM SB_MODULE_INFO WHERE userID=?");
            $sql -> bind_param("s", $_SESSION['userID']);
            $sql -> execute();
            $sql -> store_result();
            $sql -> bind_result($fetchedModuleID, $fetchedUserID, 
                                $fetchedModuleName, $fetchedCourseID, 
                                $fetchedModuleDescription, $fetchedMRS);
            while($sql -> fetch())
            {
              $result1Row['moduleID'] = $fetchedModuleID;
              $result1Row['userID'] = $fetchedUserID;
              $result1Row['moduleName'] = $fetchedModuleName;
              $result1Row['courseID'] = $fetchedCourseID;
              $result1Row['description'] = $fetchedModuleDescription;
              $result1Row['mrs'] = $fetchedMRS;
              $result1[] = $result1Row;
            }
            $sql -> close(); 
            echo "<div>";
            echo "<br>Your Modules<br>";
            if(count($result1) > 0)
            {
              echo "<table>";
              foreach($result1 as $userModule)
              {
                echo "<tr>";
                  echo "<td>".$userModule['moduleName']."</td>";
                  echo "<td>".$userModule['courseID']."</td>";
                  echo "<td>".$userModule['description']."</td>";
                echo "</tr>";
              }
              echo "</table>";
            }
            else
            {
              echo "<a href='/Pages/CreateModule.php'>You have not created any modules. You can create one here.</a>";
            }
            echo "</div>";
            echo "<div>";
            echo "<br>Your Questions<br>";
            // Parameterise SQL statement.
            $result2 = array();
            $result2Row = array();
            $sql = $mysqli -> prepare("SELECT SB_QUESTIONS.*, SB_MODULE_INFO.moduleName FROM SB_QUESTIONS INNER JOIN SB_MODULE_INFO ON SB_QUESTIONS.moduleID=SB_MODULE_INFO.moduleID WHERE SB_QUESTIONS.userID=?");
            $sql -> bind_param("s", $_SESSION['userID']);
            $sql -> execute();
            $sql -> store_result();
            $sql -> bind_result($fetchedQuestionID, $fetchedModuleID, 
                                $fetchedUserID, $fetchedQuestionContent, 
                                $fetchedELO, $fetchedQR, $fetchedModuleName);
            while($sql -> fetch())
            {
              $result2Row['questionID'] = $fetchedQuestionID;
              $result2Row['moduleID'] = $fetchedUserModuleID;
              $result2Row['userID'] = $fetchedUserID;
              $result2Row['questionContent'] = $fetechedQuestionContent;
              $result2Row['elo'] = $fetechedELO;
              $result2Row['questionRating'] = $fetchedQR;
              $result2Row['moduleName'] = $fetchedModuleName;
              $result2[] = $result2Row;
            }
            $sql -> close(); 
            if(count($result2) > 0)
            {
              echo "<table>";
              foreach($result2 as $userQuestion)
              {
                echo "<tr>";
                  echo "<td>".$userQuestion['questionContent']."</td>";
                  echo "<td>".$userQuestion['moduleName']."</td>";
                  echo "<td>".$userQuestion['moduleDescription']."</td>";
                echo "</tr>";
              }
              echo "</table>";
            }
            else
            {
              echo "<a href='/Pages/SubmitQuestion.php'>You have not created any questions. You can create one here.</a>";
            }
            echo "</div>";
            
            echo "<br><br><a href='CloseAccount.php'>Click here to close your account</a>";
          }
          else
          {
            echo "You are not logged in";
          }
        ?>
      </div>
    </div>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>
