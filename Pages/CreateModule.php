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
    <title>Create Module</title>
  </head>

  <body>
    <div id="header"></div>

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


          <!-- Some code from www.w3school.com -->
          <?php  
                               
          $codeErr = $nameErr = $descriptionErr = "";
          $name = $code = $description = $message = "";

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
              $nameErr = "Course name is required";
            } else {
              $name = test_input($_POST["name"]);
              if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed"; 
              }
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
              $group_dbnames = array(
                "2015_comp10120_m3",
              );

              require_once('../config.inc.php');

              $mysqli = new mysqli($database_host, $database_user,
                                   $database_pass, $database_name);              

              if($mysqli -> connect_error) {
                die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
              } 

              $sql = "SELECT * FROM SB_MODULE_INFO WHERE moduleCourseID='" . $code . "'";

              $result = $mysqli -> query($sql);
                       
              if ($result -> num_rows > 0) {
                $message = "The course has already been created. Please check if all information is correct.";
              } else {

                $sql = "INSERT INTO SB_MODULE_INFO (moduleName, moduleCourseID, moduleDescription) "
                ."VALUES ('" . $name . "', '" . $code . "', '" . $description . "')";

                $mysqli -> query($sql);
                $message = "Thank you for contributing to Study Buddy. The module is created successfully.";

              } // else

              $mysqli -> close();
             
            } // if

          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
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
          <input type="text" name="code" placeholder="e.g. COMP16121" value="<?php echo $code;?>">
          <span class="error"><?php echo $codeErr;?></span>
          </p><br>

          Module Name:
          <input type="text" name="name" size="50"
          placeholder="e.g. Object Orientated Programming with Java" value="<?php echo $name;?>">
          <span class="error"><?php echo $nameErr;?></span>
          </p><br>

          Module Description:<br>
          <textarea name="description" placeholder="e.g. First Year Java Course for Computer Science" rows="4" cols="63"><?php echo $description;?></textarea>
          <span class="error"><?php echo $descriptionErr;?></span>
          </p><br><br>

          <input type="submit" value="Submit Module">
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
