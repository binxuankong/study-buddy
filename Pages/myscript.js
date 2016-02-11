// Start/Stop Button.
// <button id="Start/Stop" onclick="popup(600000); changeButton;">Start</button> // Change time as input by user later.

//---------------------------------------------------------------------------------------------------------------------

// <script src="Page/myscript.js"></script>

<script type="text/javascript"> 
var timer;

function popup(time) 
{
var mylink = "ExercisePage.php";
var windowname = "Questions";


timer = setTimeout(openwindow(mylink,windowname), time);  

} 

function openwindow(mylink, windowname)
{
  var myWindow = window.open(mylink, windowname, 'type=fullwindow,fullscreen=yes,height=screen.availHeight,width=screen.availWidth,left=0,top=0,resizeable=no');
  myWindow.focus();
}

function changeButton()
{
  if (document.getElementById("Start/Stop") == "Start")
    document.getElementById("Start/Stop").innerHTML = "Stop";
  else
  {
    document.getElementById("Start/Stop").innerHTML = "Start";
    clearTimeout(timer);
  }
} // changeButton

function confirmExit(time) {
var form = document.getElementById("frml");
var full = true;
for (var i = 0; i < form.length; i++) {
  if (form[i] == "") {full = false;};
};

if (full) {
  popup(time);
  return true;
};
else {
  if(confirm('You attempt to leave the page. Have you finish all questions?'))
    popup(1);
    return true;
  else
    return false;
};
} // confirmExit
</script>