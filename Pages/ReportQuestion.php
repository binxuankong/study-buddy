<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Report.css">
    <script src="./ReportButton.js"></script>
    <title>Study Buddy - Report Question</title>
  </head>

  <body>
    <div class="heading">
      <div class="container">
        <h1>Report Question</h1>
      </div>
    </div>

    <div class="container">
 
<?php
session_start();
// Only show the report page if the user is logged in
if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
{
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
    // Update the reportReason and baseRiskPoint based on the check values.
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
    $userID = $_SESSION['userID'];
    $questionID = $_GET['questionID'];
    $result = $mysqli -> query("SELECT questionRisk FROM SB_QUESTIONS WHERE questionID='$questionID'");
    $questionRiskRow = $result -> fetch_assoc();
    $questionRisk = $questionRiskRow['questionRisk'];
    // Get the userQuestionQuality from the creator and the reporter.
    // userQuestionQuality of the reporter.
    $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$userID'");
    $reporterQuestionQualityRow = $result -> fetch_assoc();
    $reporterQuestionQuality = $reporterQuestionQualityRow['userID'];
    // userQuestionQuality of the creator.
    $result = $mysqli -> query("SELECT userID FROM SB_QUESTION WHERE questionID='$questionID'");
    $creatorUserIDRow = $result -> fetch_assoc();
    $creatorUserID = $creatorUserIDRow['userID'];
    $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$creatorUserID'");
    $creatorQuestionQualityRow = $result -> fetch_assoc();
    $creatorQuestionQuality = $creatorQuestionQualityRow['userID'];
    // Calculate the true risk point from the baseRiskPoint.
    $trueRiskPoint = $baseRiskPoint * ($reporterQuestionQuality / $creatorQuestionQuality);
    $trueRiskPoint = round($trueRiskPoint);
    // Add the current questionRisk with the trueRiskPoint.
    $questionRisk = $questionRisk + $trueRiskPoint;
    $result = $mysqli -> query("SELECT * FROM SB_REPORTED_QUESTIONS WHERE questionID='
$questionID' AND userID = '$userID'");
    $checkRow = $result -> fetch_assoc();
    // Check whether the user reported the question or not.
    // If the user has already reported the question, do not update questionRisk.
    if ($row['total'] == 0)
    {
      $report = "UPDATE SB_QUESTIONS SET questionRisk='$questionRisk' WHERE questionID='$questionID'";
    }
    // Add the datas to the reported questions table.
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
}
// If not prompt the user to create an account.
else {
  echo "<div class='errorPage'>"
         ."<h2>You must be logged in to report the question.</h2>"
         ."<img src='../Images/report_unsuccessful.png'>"
         ."<h3>Please log in below, or create an account if you do not have one.</h3>"
         ."<table><tr>"
         ."<td><button id='login' onclick='logIn()'>Log In/Sign Up</button></td>"
         ."<td><button id='close' onclick='self.close()'>Close</button></td>"
         ."</tr></table></div>";
}
?>

    </div>

  </body>
</html>
