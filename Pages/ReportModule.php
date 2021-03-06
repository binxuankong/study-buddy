<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Report.css">
    <script src="./ReportButton.js"></script>
    <title>Study Buddy - Report Module</title>
  </head>

  <body>
    <div class="heading">
      <div class="container">
        <h1>Report Module</h1>
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

  $module = $_GET['module'];
  $result = $mysqli -> query("SELECT moduleName FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
  $moduleNameRow = $result -> fetch_assoc();
  $moduleName = $moduleNameRow['moduleName'];
  // The user send the report but the text area is empty.
  if(isset($_POST['report']) && empty($_POST['others']))
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h3>What is wrong with the module <em>".$module.": ".$moduleName."</em>?</h3>"
         ."<h3 id='emptyTxtArea'>Please state the reason for you to report this module!</h3>"
         ."<p><textarea name='others' rows='10' cols='50'></textarea><br>
          <mark>Reporting a module might cause the module and all of its questions to be deleted.</mark>
          </p><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
  }
  // The user send the report and is successful.
  else if(isset($_POST['report']))
  {
    $userID = $_SESSION['userID'];
    $result = $mysqli -> query("SELECT moduleID FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
    $moduleIDRow = $result -> fetch_assoc();
    $moduleID = $moduleIDRow['moduleID'];
    $updateReportStatus = "UPDATE SB_MODULE_INFO SET moduleReportStatus=1 WHERE moduleCourseID='$moduleID'";
    $mysqli->query($updateReportStatus);
    $reportReason = $_POST['others'];
    $report = "INSERT INTO SB_REPORTED_MODULES (moduleID, reportOtherReason, userID)
               VALUES ($moduleID, '$reportReason', $userID)";

    // Update the user quality of the creator.
    $result = $mysqli -> query("SELECT userID FROM SB_MODULE_INFO WHERE moduleCourseID='$module'");
    $creatorUserIDRow = $result -> fetch_assoc();
    $creatorUserID = $creatorUserIDRow['userID'];
    $result = $mysqli -> query("SELECT userQuestionQuality FROM SB_USER_INFO WHERE userID='$creatorUserID'");
    $creatorQuestionQualityRow = $result -> fetch_assoc();
    $creatorQuestionQuality = $creatorQuestionQualityRow['userQuestionQuality'];
    $creatorQuestionQuality = $creatorQuestionQuality - 25;
    if ($creatorQuestionQuality < 50)
    {
      $creatorQuestionQuality = 50;
    }
    $updateCreatorQuality = "UPDATE SB_USER_INFO SET userQuestionQuality='$creatorQuestionQuality' WHERE userID='$creatorUserID'";
    $mysqli->query($updateCreatorQuality);

    if ($mysqli->query($report) == true) {
      echo "<div class='reportedPage'>"
         ."<h2>The module has succesfully been reported!</h2>"
         ."<img src='../Images/report_success.png'>"
         ."<h3>If other users report this module as well, the module will be hidden until it is fixed. Thank you for your contribution.</h3>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>";
    } else {
      echo "<div class='reportedPage'>"
         ."<h2>There appears to be an error!</h2>"
         ."<img src='../Images/report_unsuccessful.png'>"
         ."<h3>The module cannot be reported right now. Please try again later.</h3>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>";
    }
    //$mysqli->close();
/**/
    $result = $mysqli -> query("SELECT userID FROM SB_REPORTED_QUESTIONS WHERE questionID='$questionID'");
    $reportedUserIDRow = $result -> fetch_assoc();
    $reportedUserID = $reportedUserIDRow['userID'];
    $result = $mysqli -> query("SELECT userEmail FROM SB_USER_INFO WHERE userID='$reportedUserID'");
    $reportedUserEmailRow = $result -> fetch_assoc();
    $reportedUserEmail = $reportedUserEmailRow['userEmail'];
    $email = $reportedUserEmail;

    $mysqli->close();

    $msg = "The question you posted has one or more errors. \n "
         ."You need to revise the question.";

    $msg = wordwrap($msg,70);
    $sender = "\"Study Buddy\"";
    $subject = "Study Buddy Question Report"

    mail("$email","$subject",$msg, "","-F $sender"); 
    header("Location: /Pages/login.php");
    die();
/**/    
  }
  // The normal report page.
  else
  {
    echo "<form method='post'>"
         ."<div class='reportPage'>"
         ."<h3>What is wrong with the module <em>".$module.": ".$moduleName."</em>?</h3><br>"
         ."<p>Please state the reason for you to report this module:<br>"
         ."<textarea name='others' rows='10' cols='76'></textarea><br>
          <mark>Reporting a module might cause the module and all of its questions to be deleted.</mark>
          </p><br>"
         ."<input type='submit' name='report' value='Send Report'>"
         ."<button onclick='self.close()'>Close</button>"
         ."</div>"
         ."</form>";
  }
}
// If not prompt the user to create an account.
else {
  echo "<div class='errorPage'>"
         ."<h2>You must be logged in to report the module.</h2>"
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
