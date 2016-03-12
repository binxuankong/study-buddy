<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Report.css">
    <title>Report this Question</title>
  </head>

  <body>
    <div class="heading">
      <div class="container">
        <h1>Report</h1>
      </div>
    </div>

    <div class="container">
      <div id="reportPage">
      <h2>What is wrong with the question?</h2>
      <h3>Check the boxes which are applicable:</h3>
      <ul>
        <li>The question is completely irrelevant.
            <input type='checkbox' name='1'></li>
        <li>The question is not suitable for its module.
            <input type='checkbox' name='2'></li>
        <li>The question/choices contain spelling error.
            <input type='checkbox' name='3'></li>
        <li>The choices avaible for the question are irrelevant.
            <input type='checkbox' name='4'></li>
        <li>The correct answer(s) for the question is(are) wrong.
            <input type='checkbox' name='5'></li>
        <li>The content of the question is offensive.
            <input type='checkbox' name='6'></li>
        <li>Other reason(s):<br>
            <textarea name="others" rows="4" cols="68"></textarea></li>
      </ul><br>
      <button id="report">Send Report</button>
      <button id="close" onclick="self.close()">Close</button>
      </div>
    </div>

  </body>
</html>