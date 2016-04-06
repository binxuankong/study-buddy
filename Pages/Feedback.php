<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - Feedback</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Feedback Form</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
 
        <p>
          We welcome any feedback or comments you may have about our application.
          <form method="post">
          <br>      
          Subject:<br>
          <input type:"text" name="subject" size="71"><br><br>

          Your Comments:<br>
          <textarea name="comments" rows="10" cols="70"></textarea> <br><br>
        </p>
		      
          <input type="submit" value="Send Feedback">	
          </form>

          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>
    <?php
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
        require_once('../config.inc.php');
        $mysqli = new mysqli($database_host, $database_user,
                             $database_pass, $database_name);              
        if($mysqli -> connect_error) 
        {
          die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
        } 
        $subject = $_POST['subject'];
        $comment = $_POST['comments'];
        $sql = $mysqli -> prepare("INSERT INTO SB_FEEDBACK (feedbackSubject, feedbackMessage) VALUES (?,?)");
        $sql -> bind_param("ss", $subject, $comment);
        $sql -> execute();
        $sql -> close();
      }
    ?>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>
