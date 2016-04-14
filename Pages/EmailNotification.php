<?php
session_start();

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

  $userID = $_SESSION['userID'];
  $questionID = $_GET['questionID'];
  $result = $mysqli -> query("SELECT userID FROM SB_QUESTIONS WHERE questionRisk>100");
  $creatorUserIDRow = $result -> fetch_assoc();
  $creatorUserID = $creatorUserIDRow['userID'];
  $result = $mysqli -> query("SELECT userEmail FROM SB_USER_INFO WHERE userID='$creatorUserID'");
  $creatorUserEmailRow = $result -> fetch_assoc();
  $creatorUserEmail = $creatorUserEmailRow['userEmail'];
  $email = $creatorUserEmail;

  $msg = "The question you posted has one or more errors. \n "
         ."You need to revise the question.";

  $msg = wordwrap($msg,70);
  $sender = "\"Study Buddy\"";
  $subject = "Study Buddy Question Report"

  mail("$email","$subject",$msg, "","-F $sender"); 
  header("Location: /Pages/login.php");
  die();


?>