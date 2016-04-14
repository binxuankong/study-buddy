function reportQuestion(clickedID)
{
  var module = document.getElementById("moduleID").textContent;
  var questionID = clickedID;
  var mylink = "ReportQuestion.php?moduleID=" + module + "&questionID=" + questionID;
  var windowname = "Report Question";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=700px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}

function reportModule()
{
  var module = document.getElementById("moduleID").textContent;
  var mylink = "ReportModule.php?module=" + module;
  var windowname = "Report Module";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=700px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}

function logIn()
{
  window.opener.location.href = "login.php";
  window.close();
}

function signUp()
{
  window.opener.location.href = "login.php";
  window.close();
}
