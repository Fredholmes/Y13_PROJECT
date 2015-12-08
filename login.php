<?php

/*
 * To change this template use Tools | Templates.
 */
?>
<html>

  <head>
    <?php require_once('header.php') ?> // this gets the headder from the main file
  </head>
  
<body>
    <?php require_once('page_selection.php'); // getting the page navigaion bar ?> 
   <centre></centre><H1> THIS IS THE LOGIN PAGE</H1>
    <div id="login_div" >
        <form class="login_form" action="login.php" method="POST">
            <p><input class='login_input' type="text" name="FirstName" placeholder="Username"></p>
            <p><input class="login_input" type="password" name="FirstName" placeholder="Password"></p>
            <p><input class="login_button" type="submit" value="Login"></p>
        </form>
    </div>

  
</body>
</html>