<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/AccountManagement.css">
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
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
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
            echo "<div id='accountDetails'>";
            echo "<h2>Account details</h2>";
            echo "<table>";
              echo "<tr>";
                echo "<td width='200px'>Username:</td>";
                echo "<td><mark>".$result[0]['screenName']."</mark></td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>Name:</td>";
                echo "<td><mark>".$result[0]['firstName']." ".$result[0]['surname']."</mark></td>";
              echo "</tr>";
              echo "<tr>";
                echo "<td>Email address:</td>";
                echo "<td><mark>".$result[0]['email']."</mark></td>";
              echo "</tr>";
            echo "</table>";
            
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
            echo "</div>";
            echo "<div id='modules'>";
            echo "<h2>Your Modules</h2>";
            if(count($result1) > 0)
            {
              echo "<table>";
              echo "<tr>";
              echo "<th width='150px'>Module Code</th>";
              echo "<th width='200px'>Module Name</th>";
              echo "<th width='530px'>Module Description</th>";
              echo "</tr>";
              foreach($result1 as $userModule)
              {
                echo "<table><tr>";
                  echo "<td width='150px'>".$userModule['courseID']."</td>";
                  echo "<td width='200px'>".$userModule['moduleName']."</td>";
                  echo "<td width='530px'>".$userModule['description']."</td>";
                echo "</tr></table>";
              }
              echo "</table>";
              echo "<a href='/Pages/CreateModule.php'><button>Create more modules</button></a>";
            }
            else
            {
              echo "You have not created any modules.<br>";
              echo "<a href='/Pages/CreateModule.php'>You can create one here.</a>";
            }
            echo "</div>";

            echo "<div id='questions'>";
            echo "<h2>Your Questions</h2>";
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
              $result2Row['questionContent'] = $fetchedQuestionContent;
              $result2Row['elo'] = $fetchedELO;
              $result2Row['questionRating'] = $fetchedQR;
              $result2Row['moduleName'] = $fetchedModuleName;
              $result2[] = $result2Row;
            }
            $sql -> close(); 
            if(count($result2) > 0)
            {
              echo "<table>";
              echo "<tr>";
              echo "<th width='150px'>Module Name</th>";
              echo "<th width='350px'>Question Content</th>";
              echo "<th width='380px'>Module Description</th>";
              echo "</tr>";
              foreach($result2 as $userQuestion)
              {
                echo "<tr>";
                  echo "<td>".$userQuestion['moduleName']."</td>";
                  echo "<td>".$userQuestion['questionContent']."</td>";
                  echo "<td>".$userQuestion['moduleDescription']."</td>";
                echo "</tr>";
              }
              echo "</table>";
              echo "<a href='/Pages/CreateModule.php'><button>Create more questions</button></a>";
            }
            else
            {
              echo "You have not created any questions.<br>";
              echo "<a href='/Pages/SubmitQuestion.php'>You can create one here.</a>";
            }
            echo "</div>";
            
            echo "<br><br><a href='CloseAccount.php'><button>Click here to close your account</button></a>";
          }
          else
          {
            echo "You are not logged in";
          }
        ?>
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
