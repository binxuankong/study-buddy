<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Create Module</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
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
          $codeErr = $nameErr = $descriptionErr = "";
          $name = $code = $description = $message = "";
          if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
          {           
            $submittingUserID = $_SESSION['userID'];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              if (empty($_POST["name"])) {
                $nameErr = "Course name is required";
              } else {
                $name = test_input($_POST["name"]);
              }

              if (empty($_POST["code"])) {
                $codeErr = "Course code is required";
              } else {
                $code = strtoupper(test_input($_POST["code"]));
              }

              if (empty($_POST["description"])) {
                $descriptionErr = "Course description is required";
              } else {
                $description = test_input($_POST["description"]);
              }

              if ($codeErr == "" and $nameErr == "" and $descriptionErr == "") {

                require_once('../config.inc.php');

                $mysqli = new mysqli($database_host, $database_user,
                                     $database_pass, $database_name);              

                if($mysqli -> connect_error) {
                  die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
                } 

                // Parameterise SQL statement.
                $result = array();
                $resultRow = array();
                $sql = $mysqli -> prepare("SELECT * FROM SB_MODULE_INFO WHERE moduleCourseID=?");
                $sql -> bind_param("s", $code);
                $sql -> execute();
                $sql -> store_result();
                $sql -> bind_result($fetchedModuleID, $fetchedUserID, $fetchedModuleName, $fetchedModuleCourseID, $fetchedModuleDescription, $fetchedMRS);
                while($sql -> fetch())
                {
                  $resultRow['moduleID'] = $fetchedModuleID;
                  $resultRow['userID'] = $fetchedUserID;
                  $resultRow['moduleName'] = $fetchedModuleName;
                  $resultRow['moduleCourseID'] = $fetchedModuleCourseID;
                  $resultRow['moduleDescription'] = $fetchedModuleDescription;
                  $result[] = $resultRow;
                }
                $sql -> close();     
                if (count($result) > 0)
                {
                  $message = "The course entered already exists. Please check if all information is correct.";
                }
                else
                {

                  // Parameterise SQL statement.
                  $sql = $mysqli -> prepare("INSERT INTO SB_MODULE_INFO (userID, moduleName, moduleCourseID, moduleDescription) VALUES (?,?,?,?)");
                  $sql -> bind_param("ssss", $submittingUserID, $name, $code, $description);
                  $sql -> execute();
                  $sql -> close();
                  $message = "Thank you for contributing to Study Buddy. The module has been created successfully.";

                } // else

                $mysqli -> close();
               
              } // if

            }
          }
          else
          {
            echo "You must be signed in to create create a module.<br>"
                 ."<a href='login.php'>Please click here to sign in or register</a>";
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            return $data;
          }


          ?>


          <?php 
            echo $message;
          ?>
          <br><br>
	      

          <form method="post">
	        <p>         
          Module Code:
          <input type="text" name="code" placeholder="e.g. COMP16121" value="<?php echo $code;?>" required>
          <span class="error"><?php echo $codeErr;?></span>
          </p><br>

          Module Name:
          <input type="text" name="name" size="50"
          placeholder="e.g. Object Orientated Programming with Java" value="<?php echo $name;?>" required>
          <span class="error"><?php echo $nameErr;?></span>
          </p><br>

          Module Description: <span class="error"><?php echo $descriptionErr;?></span><br>
          <textarea name="description" placeholder="e.g. First Year Java Course for Computer Science" rows="4" cols="63" required><?php echo $description;?></textarea>
          <br><br><br>
          <input type="submit" value="Submit Module">
          </form>
          
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
