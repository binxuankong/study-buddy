// <button id="Start/Stop" onclick="clickButton(3000);">Start</button> <!--Time is in millisecond-->

var timer;
var start;

// Change between start and stop button when user click it.
// Stop timer if user click stop.
function clickButton(time)
{
  if (!start)
  {
    document.getElementById("Start/Stop").innerHTML = "Stop";
    start = true;
    popup(time);
  }
  else
  {
    document.getElementById("Start/Stop").innerHTML = "Start";
    start = false;
    clearTimeout(timer);
  }
} // clickButton


// Open a window after given time.
function popup(time) 
{
var mylink = "ExercisePage.php";
var windowname = "Questions";

timer = setTimeout(openwindow,time,mylink,windowname);
} 


// Open a window containing exercise page.
function openwindow(mylink, windowname)
{
  var myWindow = window.open(mylink, windowname, "type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no");
  myWindow.focus();
}


// Check if user has answered all questions.
// If not, pop up exercise window in 1 ms.
function confirmExit(time) {
var form = document.getElementById("frml");
var full = true;

for (var i = 0; i < form.length; i++) {
  if (form[i] == "") {full = false;};
};

if (full) {
  popup(time);
  return true;
} // if
else {
  if(confirm('You attempt to leave the page. Have you finish all questions?'))
  {
    popup(1);
    return true;
  }
  else
    return false;
} //else
}// confirmExit