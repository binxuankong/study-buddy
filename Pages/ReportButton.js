function reportQuestion()
{
  var mylink = "ReportQuestion.html";
  var windowname = "Report Question";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=600px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}

function reportModule()
{
  var mylink = "ReportModule.html";
  var windowname = "Report Module";
  var leftPosition = (window.screen.width / 2) - 400;
  var topPosition = (window.screen.height / 2) - 300;
  var myWindow = window.open(mylink, windowname, "height=600px, width=800px, top=" + topPosition + ", left=" + leftPosition + "location=no, statusbar=no, toolbar=no");
  myWindow.focus();
}
