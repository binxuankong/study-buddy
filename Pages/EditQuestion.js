function editQuestion(clickedID)
{
  var question = clickedID;
  var mylink = "EditQuestion.php?question=" + question;
  var windowname = "Edit Question";
  var myWindow = window.open(mylink, windowname, "type=fullwindow, fullscreen=yes, menubar=yes, status=yes,titlebar=yes, toolbar=yes, height=screen.availHeight, width=screen.availWidth, left=0, top=0, resizeable=yes, scrollbars=yes");
  myWindow.focus();
}
