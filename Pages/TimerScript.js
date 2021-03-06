var timer;
var start = false;
var time = 600;
window.chosenTime;

function setValue(requiredTime)
{ 
  time = requiredTime;
}
function increaseTime()
{
  if (!start)
  {
    time = time + 30;
    displayTime();
  }
}

function decreaseTime()
{
  if (!start)
  {
    if(!(time - 30 < 0))
    {
      time = time - 30;
    }
    displayTime();
  }
}
function increaseTimeTen()
{
  if (!start)
  {
    time = time + 10;
    displayTime();
  }
}

function decreaseTimeTen()
{
  if (!start)
  {
    if(!(time - 10 < 0))
    {
      time = time - 10;
    }
    displayTime();
  }
}

function tick()
{
  if(time == 0)
  {
    clearInterval(timer);
    openWindow();
  }
  else
  {
    time = time - 1;
  }
  displayTime();
  
}

function displayTime()
{
  var seconds = time % 60;
  if(time % 60 < 10)
  {
    seconds = "0" + (time % 60);
  }
  var timeString = "".concat(Math.floor(time / 60), ":", seconds);
  document.getElementById("time").innerHTML = timeString;
}
// Change between start and stop button when user click it.
// Stop timer if user click stop.
function clickButton()
{
  if (!start)
  {
    document.getElementById("moduleDropdown").disabled = true;
    var moduleSelected = document.getElementById("moduleDropdown");
    moduleSelected = moduleSelected.options[moduleSelected.selectedIndex].value;
    
    if(moduleSelected != "Choose a module")
    {
      document.getElementById("errorLabel").innerHTML = "";
      displayTime();
      document.getElementById("Start-Stop").innerHTML = "Stop";
      start = true;
      chosenTime = time;
      timer = setInterval(tick, 1000);
      document.getElementById("initialTimeLabel").innerHTML = "Time until exercise";
    }
    else
    {
      document.getElementById("errorLabel").innerHTML = "Select a module before starting.";
      document.getElementById("moduleDropdown").disabled = false;
    }
  }
  else if (start && time != 0)
  {
      document.getElementById("moduleDropdown").disabled = false;
      document.getElementById("Start-Stop").innerHTML = "Start";
      time = chosenTime;
      displayTime();
      start = false;
      document.getElementById("initialTimeLabel").innerHTML = "Set an initial time";
      clearInterval(timer);
  }
  else
  {
    time = chosenTime;
    timer = setInterval(tick, 1000);
  }
} // clickButton

// Open a window containing exercise page.
function openWindow()
{
  var module = document.getElementById("moduleDropdown");
  module = module.options[module.selectedIndex].text;
  var mylink = "ExercisePage.php?module=" + module;
  var windowname = "Questions";
  start = false;
  time = chosenTime;
  displayTime();
  document.getElementById("moduleDropdown").disabled = false;
  document.getElementById("initialTimeLabel").innerHTML = "Set an initial time";
  document.getElementById("Start-Stop").innerHTML = "Start";
  var myWindow = window.open(mylink, windowname, "type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no,scrollbars=yes");
  myWindow.focus();
}
function resetTimer()
{
  // Take the time chosen by the user
  time = window.opener.chosenTime;
  // Take the number of correct questions from ExcercisePage.php
  var answeredCorrectly = timeDiff;
  // If all questions are answered correctly, and the time is less than 10 minutes, increase the time by 30s
  if (answeredCorrectly > 0) {
    if (time < 600)
      for(count = answeredCorrectly; count > 0; count--)
        window.opener.increaseTimeTen();
  }
  //if not, and the time is 1 minute or more, decrease it by 30s
  else
  {
    if (time >= 60)
    {
      for(count = answeredCorrectly; count < 0; count++)
        window.opener.decreaseTimeTen();
    }
  }
  window.opener.clickButton();
  window.close();
}
