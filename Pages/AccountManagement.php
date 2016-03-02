<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Template</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Template</h1>
      </div>
    </div>
	      
    <div class="body">
      <div class="container">
        <?php
          if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
          {
            require_once('../config.inc.php');
          }
          else
          {
            echo "You are not logged in";
          }
        ?>
      </div>
    </div>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>
