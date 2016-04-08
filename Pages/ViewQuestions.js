function clickButton()
{
  var moduleSelected = document.getElementById("moduleDropdown");
  moduleSelected = moduleSelected.options[moduleSelected.selectedIndex].value;
    
  if(moduleSelected != "Choose a module")
  {
    document.getElementById("errorLabel").innerHTML = "";
    openWindow();
    }
  else
  {
    document.getElementById("errorLabel").innerHTML = "<br>Select a module to view questions.";
    document.getElementById("moduleDropdown").disabled = false;
  }
}

function openWindow()
{
  var module = document.getElementById("moduleDropdown");
  module = module.options[module.selectedIndex].text;
  var mylink = "QuestionList.php?module=" + module;
  var windowname = "Question List";
  var myWindow = window.open(mylink, windowname, "type=fullwindow, fullscreen=yes, menubar=yes, status=yes,titlebar=yes, toolbar=yes, height=screen.availHeight, width=screen.availWidth, left=0, top=0, resizeable=yes, scrollbars=yes");
  myWindow.focus();
}
