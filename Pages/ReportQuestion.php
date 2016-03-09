<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Report.css">
    <title>Report this Question</title>
  </head>

  <body>
    <div class="heading">
      <div class="container">
        <h1>Report Question</h1>
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
         ."<h2>The question has succesfully been reported!</h2>"
         ."<img src='../Images/report_success.png'>"
         ."<h3>If other users report this question as well, the question will be hidden until it is fixed. Thank you for your contribution.</h3>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>";
  }
  else
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h2>What is wrong with the question?</h2>"
         ."<h3>Check the boxes which are applicable:</h3>"
         ."<ul>
           <li>The question is completely irrelevant.
               <input type='checkbox' name='1'></li>
           <li>The question is not suitable for its module.
               <input type='checkbox' name='2'></li>
           <li>The question/choices contain spelling error.
               <input type='checkbox' name='3'></li>
           <li>The choices avaible for the question are irrelevant.
               <input type='checkbox' name='4'></li>
           <li>The correct answer(s) for the question is(are) wrong.
               <input type='checkbox' name='5'></li>
           <li>The content of the question is offensive.
               <input type='checkbox' name='6'></li>
           <li>Other reason(s):<br>
               <textarea name='others' rows='4' cols='68'></textarea></li>
           </ul><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
  }
?>

    </div>

  </body>
</html>
