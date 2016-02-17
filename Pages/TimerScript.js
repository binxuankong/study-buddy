// <button id="Start-Stop" onclick="clickButton(3000);">Start</button> <!--Time is in millisecond-->
var timer;
var start = false;
var time = 600;

function increaseTime()
{
  time = time + 30;
  displayTime();
}

function decreaseTime()
{
  if(time != 0)
  {
    time = time - 30;
  }
  displayTime();
}

function tick()
{
  time = time - 1;
  displayTime();
  if(time == 0)
  {
    openWindow();
  }
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
    document.getElementById("Start-Stop").innerHTML = "Stop";
    start = true;
    timer = setInterval(tick, 1000);
  }
  else
  {
    document.getElementById("Start-Stop").innerHTML = "Start";
    start = false;
    clearInterval(timer);
  }
} // clickButton

// Open a window containing exercise page.
function openwindow()
{
  var mylink = "ExercisePage.php";
  var windowname = "Questions";
  var myWindow = window.open(mylink, windowname, "type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no");
  myWindow.focus();
}
