var timer;
var start = false;
var time = 600;
var chosenTime;

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
      document.getElementById("initialTimeLabel").innerHTML = "Time until exercise <span class='dropt' title='Module Description'><img src='../Images/information.png'> <span style='width:500px;'>The timer is now running, counting down the time to the next exercise.<br>When the timer reaches 0, the exercise page will pop-up.<br>When the exercise is completed, the timer will change according to how well you performed in the exercise, and will automatically run again.<br>Click the <b>Stop</b> button to stop the timer.</span></span>";
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
      document.getElementById("initialTimeLabel").innerHTML = "Set an initial time <span class='dropt' title='Module Description'><img src='../Images/information.png'> <span style='width:500px;'>The initial time of the timer.<br>When the timer reaches 0, the exercise page will pop-up.<br>When the exercise is completed, the timer will change according to how well you performed in the exercise, and will automatically run again.<br>The <b>+</b> button will increase the initial time of the timer by 30 seconds.</br>The <b>-</b> button will decrease the initial time of the timer by 30 seconds.<br>Click the <b>Start Timer</b> button to start the timer.</span></span>";
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
  document.getElementById("initialTimeLabel").innerHTML = "Set an initial time <span class='dropt' title='Module Description'><img src='../Images/information.png'> <span style='width:500px;'>The initial time of the timer.<br>When the timer reaches 0, the exercise page will pop-up.<br>When the exercise is completed, the timer will change according to how well you performed in the exercise, and will automatically run again.<br>The <b>+</b> button will increase the initial time of the timer by 30 seconds.</br>The <b>-</b> button will decrease the initial time of the timer by 30 seconds.<br>Click the <b>Start Timer</b> button to start the timer.</span></span>";
  document.getElementById("Start-Stop").innerHTML = "Start";
  var myWindow = window.open(mylink, windowname, "type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no,scrollbars=yes");
  myWindow.focus();
}
function resetTimer()
{
  // Close the popup window
  window.close();

  // Refresh the timer page after the popup window was closed
  window.onunload = refreshParent;
  function refreshParent() {
    window.opener.location.reload();
  }

  // Take the time chosen by the user
  time = chosenTime;

  // Take the number of correct questions from ExcercisePage.php
  var answeredCorrectly = "<?php echo $correctQuestions; ?>";
  // If all questions are answered correctly, and the time is less than 10 minutes, increase the time by 30s
  if (answeredCorrectly == 5) {
    if (time < 600)
      increaseTime();
  }
  //if not, and the time is 1 minute or more, decrease it by 30s
  else
    if (time >= 60)
      decreaseTime();
  /* This part is not working
  document.getElementById("errorLabel").innerHTML = "";
  displayTime();
  document.getElementById("Start-Stop").innerHTML = "Stop";
  timer = setInterval(tick, 1000);
  document.getElementById("initialTimeLabel").innerHTML = "Time until exercise:";
  */
}
