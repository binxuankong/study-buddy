<div class="nav">
  <div class="container">
    <ul class="pull-left">
       <a href="/index.php"><div id="logo"></div>
       <li id="webpagename">Study Buddy</li></a>
    </ul>
    <ul class="pull-right">
      <?php        
        if(isset($_SESSION['userID']) && isset($_SESSION['userName']))
        {
          $username = $_SESSION['userName'];
          echo "<li><a href='/Pages/AccountManagement.php'><img src='/Images/new_user.png' alt='User Profile'></a></li>";
          echo "<li id='signup'><a href='/Pages/AccountManagement.php'>$username</a></li>";
          echo "<li id='logout'><img src='/Images/logout.png' alt='Log Out' title='Log Out'></li>";
        }
        else
        {
          echo "<li><a href='/Pages/login.php'><img src='/Images/new_user.png' alt='User Profile'></a></li>";
          echo "<li id='signup'><a href='/Pages/login.php'>Sign Up/Log In</a></li>";
        }
      ?>
    </ul>
  </div>
</div>
