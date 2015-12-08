<?php
require_once ('db_connect.php'); // this connects to the database

session_start();	//this starts the session

if(!$_SESSION['logged_in_instructor']){  //checking if session is logged in
	header("Location: /index.php"); // re-directs if not logged in
}

if(isset($_POST['adduser'])){

    $errors = array(); // array for errors when checking data
    
    $center_id = $_SESSION['center_id']; // gettingv the center id of the instructor/admin that is logged in so that the user is added to the correct cetner
    
	$username = $_POST['username']; //getting the data from the form on the html
    $pass = $_POST['password'];
    $name = $_POST['real_name'];
    $user_type = $_POST['user_type'];
    
    if($user_type == "instructor"){ // deciding if the user is an instructor or a standard user
        $instructor = 1;
    }
    else{
        $instructor = 0;
    }
    
//////////////////////////////////////////////////////////////////////////////////////////////// error checking ///////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    if(strlen($username) < 4){
        $errors[]= 'please enter a username that is greater than 4 charachters';
    }
    
    if(strlen($name) < 4){
        $errors[]= 'please enter a name';
    }
    
    if(strlen($pass) < 4){
        $errors[]= 'please enter a password that is greater then 4 charachters';
    }  
    
    $sql_define_1 = "SELECT * FROM users WHERE username = '$username'"; // checking to see if the username has been taken
    $sql_run_1 = mysql_query($sql_define_1); //runs the querey on database
	$sql_rows_1 = mysql_num_rows($sql_run_1); // see how many results there are
    
    if($sql_rows_1 == 1){
        $errors[] = 'this username has been taken, please choose another one';
    }
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    if(empty($errors)){ // if there are no errors thent the user will be added to the data base

        $hashed_password = password_hash($pass, PASSWORD_DEFAULT); //hash the password for security after checking for errors
        
        $sql_define_2 = "INSERT INTO users(username, password, real_name, instructor, number_logs, center_id) VAlUES('$username','$hashed_password','$name','$instructor','0','$center_id')"; // add a new user
		$sql_run_2 = mysql_query($sql_define_2);
		echo'user registered';
        if($instructor == 1){
            $sql_define_3 = "UPDATE center SET number_instructors=number_instructors+1 WHERE center_id = '$center_id'";
            $sql_run_3 = mysql_query($sql_define_3);
        }
        else{
            $sql_define_3 = "UPDATE center SET number_climbers=number_climbers+1 WHERE center_id = '$center_id'";
            $sql_run_3 = mysql_query($sql_define_3);
        }

    }
    else{
        $errors[] = 'nope not worked';
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
    <a href='logout.php'><input name='logout' type='submit' value='logout'></a>
    <a href='instructorpage.php'><input name='login' type="submit" value='instructor page '></a>
    <?php
        if(isset($errors)) //displaying the errors for the sign up
        {
	    foreach($errors AS $msg)
	    {
		echo $msg . "<br>";
	    }
    }
    ?>   
      
    
    <form action='/adduser.php' method="post" name='adduser'>
        username : <input name='username' type='text'>
        passoword  : <input name='password' type="password">
        Real name : <input name='real_name' type='text' >
        standard user<input type="radio" name="user_type" value="standard" checked>
        instructor<input type="radio" name="user_type" value="instructor">
        <input name='adduser' type='submit' value='submit' >
    </form>
  </body>
</html>