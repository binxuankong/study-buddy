<?php session_start(); ?>
<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <link rel="stylesheet" href="../CSS/AboutUs.css">
    <script src="jquery.js"></script>
    <title>Study Buddy - About Us</title>
  </head>

  <body>
    <div id="header">
      <?php include('../Template/header.php'); ?>
    </div>

    <div class="heading">
      <div class="container">
        <h1>About Us</h1>
      </div>
    </div>

    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-10">

  <p>The team behind this website is the M3 Group of the School of Computer Science from the University of Manchester. This web application is created for the COMP10120 first-year team project. The purpose of this application is to help the users be aware of their procrastination.</p>

  <h2>Meet the Team</h2>
  <table id="theTeam">
    <tr>
      <td><img src="../Images/new_user.png"><br>Ben Lister</td>
      <td><img src="../Images/new_user.png"><br>Ellis Judge</td>
    </tr>
    <tr>
      <td><img src="../Images/new_user.png"><br>Yangguang Li</td>
      <td><img src="../Images/new_user.png"><br>Mihai Deaconu</td>
    </tr>
    <tr>
      <td><img src="../Images/new_user.png"><br>Wonkwon Lee</td>
      <td><img src="../Images/new_user.png"><br>Bin Xuan Kong</td>
    </tr>
  </table>

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
