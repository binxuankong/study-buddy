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

  // Check if the other reason check box is ticked.
  $otherReason = false;
  if(isset($_POST['report']) && !empty($_POST['checklist']))
  {
    foreach($_POST['checklist'] as $checkValue)
    {
      if ($checkValue == '7')
        $otherReason = true;
    }   
  }
  // The user send the report but none of the check boxes are checked.
  if(isset($_POST['report']) && empty($_POST['checklist']))
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h2>What is wrong with the question?</h2>"
         ."<h3 id='emptyTxtArea'>Please check the boxes which are applicable!</h3>"
         ."<ul>
           <li>The question is completely irrelevant.
               <input type='checkbox' name='checklist[]' value='1'></li>
           <li>The question is not suitable for its module.
               <input type='checkbox' name='checklist[]' value='2'></li>
           <li>The question/choices contain spelling error.
               <input type='checkbox' name='checklist[]' value='3'></li>
           <li>The choices avaible for the question are irrelevant.
               <input type='checkbox' name='checklist[]' value='4'></li>
           <li>The correct answer(s) for the question is(are) wrong.
               <input type='checkbox' name='checklist[]' value='5'></li>
           <li>The content of the question is offensive.
               <input type='checkbox' name='checklist[]' value='6'></li>
           <li>Other reason(s):
               <input type='checkbox' name='checklist[]' value='7'><br>
               <textarea name='others' rows='4' cols='68'></textarea></li>
           </ul><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
  }
  // The user checked other reasons but the text area is empty.
  elseif(isset($_POST['report']) && $otherReason && empty($_POST['others']))
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h2>What is wrong with the question?</h2>"
         ."<h3 id='emptyTxtArea'>Please state the other reason(s)!</h3>"
         ."<ul>
           <li>The question is completely irrelevant.
               <input type='checkbox' name='checklist[]' value='1'></li>
           <li>The question is not suitable for its module.
               <input type='checkbox' name='checklist[]' value='2'></li>
           <li>The question/choices contain spelling error.
               <input type='checkbox' name='checklist[]' value='3'></li>
           <li>The choices avaible for the question are irrelevant.
               <input type='checkbox' name='checklist[]' value='4'></li>
           <li>The correct answer(s) for the question is(are) wrong.
               <input type='checkbox' name='checklist[]' value='5'></li>
           <li>The content of the question is offensive.
               <input type='checkbox' name='checklist[]' value='6'></li>
           <li>Other reason(s):
               <input type='checkbox' name='checklist[]' value='7'><br>
               <textarea name='others' rows='4' cols='68'></textarea></li>
           </ul><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
    $otherReason = false;
  }
  // The user send the report and is successful.
  elseif(isset($_POST['report']))
  {
    $reportReason = 0;
    $baseRiskPoint = 0;
    foreach($_POST['checklist'] as $checkValue)
    {
      if($checkValue =='1')
      {
        $reportReason = $reportReason + 16;
        $baseRiskPoint = $baseRiskPoint + 15;
      }
      if($checkValue =='2')
      {
        $reportReason = $reportReason + 8;
        $baseRiskPoint = $baseRiskPoint + 15;
      }
      if($checkValue =='3')
      {
        $reportReason = $reportReason + 1;
        $baseRiskPoint = $baseRiskPoint + 5;
      }
      if($checkValue =='4')
      {
        $reportReason = $reportReason + 4;
        $baseRiskPoint = $baseRiskPoint + 10;
      }
      if($checkValue =='5')
      {
        $reportReason = $reportReason + 2;
        $baseRiskPoint = $baseRiskPoint + 10;
      }
      if($checkValue =='6')
      {
        $reportReason = $reportReason + 64;
        $baseRiskPoint = $baseRiskPoint + 25;
      }
      if($checkValue =='7')
      {
        $reportReason = $reportReason + 32;
        $baseRiskPoint = $baseRiskPoint + 20;
        $otherReason = $_POST['others'];
      }
    }
    $questionID = $_GET['questionID'];
    $result = $mysqli -> query("SELECT questionRisk FROM SB_QUESTIONS WHERE questionID='$questionID'");
    $questionRiskRow = $result -> fetch_assoc();
    $questionRisk = $questionRiskRow['questionRisk'];
    $questionRisk = $questionRisk + $baseRiskPoint;
    $report = "UPDATE SB_QUESTIONS SET questionRisk='$questionRisk' WHERE questionID='$questionID'";
    if (isset($otherReason))
    {
      $report = "INSERT INTO SB_REPORTED_QUESTIONS (questionID, reportReason, otherReason)
                 VALUES ($questionID, $reportReason, $otherReason)";
    }
    else
    {
      $report = "INSERT INTO SB_REPORTED_QUESTIONS (questionID, reportReason, otherReason)
                 VALUES ($questionID, $reportReason, NULL)";
    }
    if ($mysqli->query($report) == true) {
      echo "<div class='reportedPage'>"
          ."<h2>The question has succesfully been reported!</h2>"
          ."<img src='../Images/report_success.png'>"
           ."<h3>If other users report this question as well, the question will be hidden until it is fixed. Thank you for your contribution.</h3>"
           ."<button onclick='self.close()'>Close</button>"
          ."</div>";
    } else {
      echo "<div class='reportedPage'>"
         ."<h2>There appears to be an error!</h2>"
         ."<img src='../Images/report_unsuccessful.png'>"
         ."<h3>The question cannot be reported right now. Please try again later.</h3>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>";
    }
    $mysqli->close();
  }
  // The normal report page.
  else
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h2>What is wrong with the question?</h2>"
         ."<h3>Check the boxes which are applicable:</h3>"
         ."<ul>
           <li>The question is completely irrelevant.
               <input type='checkbox' name='checklist[]' value='1'></li>
           <li>The question is not suitable for its module.
               <input type='checkbox' name='checklist[]' value='2'></li>
           <li>The question/choices contain spelling error.
               <input type='checkbox' name='checklist[]' value='3'></li>
           <li>The choices avaible for the question are irrelevant.
               <input type='checkbox' name='checklist[]' value='4'></li>
           <li>The correct answer(s) for the question is(are) wrong.
               <input type='checkbox' name='checklist[]' value='5'></li>
           <li>The content of the question is offensive.
               <input type='checkbox' name='checklist[]' value='6'></li>
           <li>Other reason(s):
               <input type='checkbox' name='checklist[]' value='7'><br>
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
