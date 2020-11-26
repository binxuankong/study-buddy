<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="CSS/bootstrap.css">
    <link rel="stylesheet" href="CSS/HomePage.css">
    <script src="Pages/jquery.js"></script>
    <title>Study Buddy</title>
  </head>

  <body>
    <div id="header">
      <?php include('./Template/header.php'); ?>
    </div>

    <div class="jumbotron">
      <div class="container">
        <h1>It's study time.</h1>
        <a href="./Pages/Timer.php">START NOW</a>
      </div>
    </div>
    
    <div class="body">
      <table>
        <tbody>
          <tr>
            <td id="module"><a href="./Pages/CreateModule.php">Create a module</a></td>
            <td id="question"><a href="./Pages/SubmitQuestion.php">Submit a question</a></td>
            <td id="getstarted"><a href="./Pages/Timer.php">Start timer</a></td>
            <td id="bugreport"><a href="./Pages/AllQuestions.php">View questions</a></td>
          </tr>
        </tbody>
      </table>
  	</div>

    <div id="footer">
      <?php include('./Template/footer.php'); ?>
    </div>
	
  </body>
</html>
