// <button id="Start-Stop" onclick="clickButton(3000);">Start</button> <!--Time is in millisecond-->
var timer;
var start = false;
var time = 600;
var chosenTime;
displayTime();
function increaseTime()
{
  time = time + 30;
  displayTime();
}

function decreaseTime()
{
  if(!(time - 30 < 0))
  {
    time = time - 30;
  }
  displayTime();
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
    displayTime();
    document.getElementById("Start-Stop").innerHTML = "Stop";
    start = true;
    chosenTime = time
    document.getElementById("moduleDropdown").disabled = true;
    timer = setInterval(tick, 1000);
    document.getElementById("initialTimeLabel").innerHTML = "Time until exercise:";
  }
  else
  {
    document.getElementById("Start-Stop").innerHTML = "Start";
    time = chosenTime;
    displayTime();
    start = false;
    document.getElementById("moduleDropdown").disabled = false;
    document.getElementById("initialTimeLabel").innerHTML = "Set an initial time:";
    clearInterval(timer);
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
  document.getElementById("initialTimeLabel").innerHTML = "Set an initial time:";
  document.getElementById("Start-Stop").innerHTML = "Start";
  var myWindow = window.open(mylink, windowname, "type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no");
  myWindow.focus();
}
