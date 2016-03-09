<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Report.css">
    <title>Report this Module</title>
  </head>

  <body>
    <div class="heading">
      <div class="container">
        <h1>Report Module</h1>
      </div>
    </div>

    <div class="container">

<?php
  require_once('../config.inc.php');
  $mysqli = new mysqli($database_host, $database_user, 
  $database_pass, $database_name);

  if($mysqli -> connect_error) 
  {
    die('Connect Error ('.$mysqli -> connect_errno.') '
        .$mysqli -> connect_error);
  }

  if(isset($_POST['report']))
  {
    echo "<div class='reportedPage'>"
         ."<h2>The module has succesfully been reported!</h2>"
         ."<img src='../Images/report_success.png'>"
         ."<h3>If other users report this module as well, the module will be hidden until it is fixed. Thank you for your contribution.</h3>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>";
  }
  else
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h2>What is wrong with the module?</h2>"
         ."<h3>Please state the reason for you to report this module:</h3>"
         ."<p><textarea name='others' rows='10' cols='76'></textarea><br>
          <mark>Reporting a module might cause the module and all of its questions to be deleted.</mark>
          </p><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
  }
?>

    </div>

  </body>
</html>
