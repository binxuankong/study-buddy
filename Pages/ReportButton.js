function reportQuestion(clickedID)
{
  var module = document.getElementById("moduleID").textContent;
  var questionID = clickedID;
  if (questionID < 10)
    var mylink = "ReportQuestion.php?questionID=" + module + "000" + questionID;
  else if (questionID < 100)
    var mylink = "ReportQuestion.php?questionID=" + module + "00" + questionID;
  else if (questionID < 1000)
    var mylink = "ReportQuestion.php?questionID=" + module + "0" + questionID;
  else
    var mylink = "ReportQuestion.php?questionID=" + module + questionID;
  var windowname = "Report Question";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=600px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}

function reportModule()
{
  var module = document.getElementById("moduleID").textContent;
  var mylink = "ReportModule.php?module=" + module;
  var windowname = "Report Module";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=600px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}
