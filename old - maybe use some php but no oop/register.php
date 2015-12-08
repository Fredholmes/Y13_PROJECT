<?php

require_once ('db_connect.php'); //connecting to the database

if(isset($_POST['register'])){
    
    $errors = array(); // array for errors when checking data
    
	$username = $_POST['admin_username']; //getting the data from the form on the html
    $pass = $_POST['admin_password'];
    $center_name = $_POST['center_name'];
    $email = $_POST['admin_email'];
    $name = $_POST['real_name'];
    
//////////////////////////////////////////////////////////////////////////////////////////////// error checking ///////////////////////////////////////////////////////////////////////////////////////////////////
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[]= 'enter a vaild email';
    }
    
    if(strlen($center_name) < 4){
        $errors[]= 'please enter a center name that is greater than 4 charachters, if this is a problem please contact %email to be put here%';
    }
    
    if(strlen($username) < 4){
        $errors[]= 'please enter an admin username that is greater than 4 charachters';
    }
    
    if(strlen($pass) < 6){
        $errors[]= 'please enter a password that is greater then 6 charachters';
    }
   
    $sql_define_1 = "SELECT * FROM center WHERE center_name = '$center_name'"; // checking to see if the center has already been registered
    $sql_run_1 = mysql_query($sql_define_1); //runs the querey on database
	$sql_rows_1 = mysql_num_rows($sql_run_1); // see how many results there are
    
    if($sql_rows_1 == 1){
       $errors[]= 'this center has already been registered';
    }    
    
    $sql_define_2 = "SELECT * FROM center WHERE username = '$username'"; // checking to see if the username has been taken
    $sql_run_2 = mysql_query($sql_define_2); //runs the querey on database
	$sql_rows_2 = mysql_num_rows($sql_run_2); // see how many results there are
    
    if($sql_rows_2 == 1){
        $errors[] = 'this username has been taken, please choose another one';
    }
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    
    if(empty($errors)){
        
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT); //hash the password for security after checking for errors

            $sql_define_3 = "INSERT INTO center(username, password, admin_email, center_name, number_climbers, number_instructors, real_name) VAlUES('$username','$hashed_password','$email','$center_name','0','1','$name')"; // add a new center
		    $sql_run_3 = mysql_query($sql_define_3);
		    echo' this center has been registered!';
            session_start();
			$_SESSION['logged_in_instructor'] = true; //starting a session 
        
            $sql_define_4 = "SELECT center_id FROM center WHERE username = '$username'"; // getting the center id 
            $get_center_id = mysql_query($sql_define_4);
            $data2 = mysql_fetch_array($get_center_id);
            $center_id = $data2['center_id'];
            $_SESSION['center_id'] = $center_id;
            echo $center_id;
            header("Refresh:3; url=/instructorpage.php", true, 303); 
    }
} // end of manin if statement

?>
  



<!DOCTYPE html>
<html>

  <head>
    
    <title> climlog - no formatting </title>
    
  </head>

    
  <body>
    <a href='index.php'><input name='home' type='submit' value='home'></a>

    <?php
        if(isset($errors)) //displaying the errors for the sign up
        {
	    foreach($errors AS $msg)
	    {
		echo $msg . "<br>";
	    }
    }
    ?>

    <form action='register.php' method='post' name='register'>
        center name : <input name='center_name' type="text" id='center_name'>
        admin username : <input name='admin_username' type='text' id='username'>
        admin passowrd  : <input name='admin_password' type="password" id='password'>
        admin email : <input name='admin_email' type='te' >
        Real name : <input name='real_name' type='text' >
        <input name='register' type='submit' value='submit' >
    </form>
  </body>
    
</html>

