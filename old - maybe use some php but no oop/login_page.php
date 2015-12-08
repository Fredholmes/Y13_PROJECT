<?php

require_once ('db_connect.php'); //connecting to the database

if(isset($_POST['login'])){
    
    $errors = array(); // array for errors when checking data
    
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $user_type = $_POST['user_type'];
    
    if($user_type == "admin_user"){ // deciding if the user is an admin or a standard user
        $admin = 1; // sending to the correct page if admin user
        $table = 'center'; // getting the correct table in the sql
    }
    else{
        $admin = 0;
        $table = 'users'; // getting the correct table in the sql
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////// errors ///////////////////////////////////////////////////////////////////////////////////////////////////    
    
    if(empty($user)){
        $errors[] = 'please enter a username';
    }
    
    if(empty($pass)){
        $errors[] = 'please enter a password';
    }
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

    if(empty($errors)){ 
        $sql_define_1 = "SELECT password FROM $table WHERE username = '$user'"; // getting the hashed passoword
        $get_hash = mysql_query($sql_define_1);
        $data = mysql_fetch_array($get_hash);
        $hash_pass = $data['password'];
        
        if (password_verify($pass, $hash_pass)) {
            // Success!
            $errors[] = 'success' ;
            
            if (password_needs_rehash($hash_pass, PASSWORD_DEFAULT, ['cost' => 12])) {
            // the password needs to be rehashed as it was not generated with
            // the current default algorithm or not created with the cost
            $new_hash = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
            $sql_define_2 = "UPDATE $table SET password='$new_hash' WHERE username = '$user'";
            $sql_run_2 = mysql_query($sql_define_2);
            }
            
            $sql_define_3 = "SELECT instructor FROM users WHERE username = '$user'";
            $sql_run_2 = mysql_query($sql_define_3);
            $data_2 = mysql_fetch_array($sql_run_2);
            $instructor = $data_2['instructor'];
            
            if($instructor == 1 or $admin == 1){ // deciding which page to send the user to depending if they are an instructor/admin or a standard user
                session_start();
			    $_SESSION['logged_in_instructor'] = true; //starting a session
                $_SESSION['logged_in_user'] = true; //starting a session 
                
                $sql_define_3 = "SELECT center_id FROM $table WHERE username = '$user'"; // getting the center id
                $get_center_id = mysql_query($sql_define_3);
                $data2 = mysql_fetch_array($get_center_id);
                $center_id = $data2['center_id'];
                $_SESSION['center_id'] = $center_id;
                
                header("Refresh:3; url=/instructorpage.php", true, 303);
            }
            else{
                session_start();
			    $_SESSION['logged_in_user'] = true; //starting a session 
                
                
                $sql_define_3 = "SELECT center_id,user_id FROM $table WHERE username = '$user'"; // getting the center id
                $get_center_id = mysql_query($sql_define_3);
                $data2 = mysql_fetch_array($get_center_id);
                
                $_SESSION['center_id'] = $data2['center_id'];
                
                $_SESSION['user_id'] = $data2['user_id'];
                header("Refresh:3; url=/userpage.php", true, 303); // refresh after 3 seconds
            }
        }
        else {
            // Invalid credentials
            $errors[] = 'nope';
        }
    }
    
} // end of main if statement
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
    <form action='login_page.php' method='post' name='login'>
        username : <input name='username' type="text">
        password : <input name='password' type='password'>
        standard<input type="radio" name="user_type" value="standard_user" checked>
        admin<input type="radio" name="user_type" value="admin_user">
        <input name='login' type='submit' value='login'>
    </form>
  </body>
  
</html>