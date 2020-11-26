var counter = 2;
var limit = 8;
function addInput(divName)
{
  if(counter != limit)
  {
    var newdiv = document.createElement('div');
    newdiv.innerHTML = "Answer " + (counter + 1)
                       + " <input type='text' name='ans[" + counter + "][0]' size='64'>"
                       + " <input type='checkbox' name='ans[" + counter + "][1]' ><br>";
    document.getElementById(divName).appendChild(newdiv);
    counter++;
    if(counter == limit)
    {
      document.getElementById("removable").id = "removableDisabled";
    }
  }
}
