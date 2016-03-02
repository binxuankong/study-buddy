<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/Template.css">
    <script src="jquery.js"></script>
    <title>Feedback</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>Feedback Form</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">
 
        <p>
          We welcome any feedback or comments you may have about our application.
      
          <form action="MAILTO:benlister010@gmail.com" method="post" enctype="text/plain">
          <p>      
          Subject:<br>
          <input type:"text" name="subject" size="51" required> <br>
          Your Comments:<br>
          <textarea name="Comments" rows="10" cols="50" required>
          </textarea> <br><br>
		      
          <input type="submit" value="Send Feedback">	
          </p>	
          </form>
        </p>

          </div>
          <div class="col-md-1">
          </div>
        </div>
      </div>
    </div>

    <div id="footer">
      <?php include('../Template/footer.php'); ?>
    </div>
	
  </body>
</html>