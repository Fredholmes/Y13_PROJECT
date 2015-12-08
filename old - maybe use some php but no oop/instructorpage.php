<?php

require_once ('db_connect.php'); // this connects to the database

session_start();	//this starts the session

if(!$_SESSION['logged_in_instructor']){  //checking if session is logged in
	header("Location: /index.php"); // re-directs if not logged in
}

if(isset($_POST['view_user'])){
    
    $user_id = $_POST['user_id'];
    $_SESSION['user_id'] = $user_id;
    header("Location: /userpage.php");

}
    
$center_id = $_SESSION['center_id']; //getting the center id of the logged in user

$sql_define_2 = "SELECT * FROM users WHERE center_id = $center_id AND instructor = 0"; //assigning the sql statement
$climbers = mysql_query($sql_define_2); // running the sql statement
$num_climbers = mysql_num_rows($climbers); //counting the rows for later
    
?>

<!DOCTYPE html>
<html>

  <head>
    
    <title> climlog - no formatting </title>
    
  </head>
  
  <body>
      <a href='index.php'><input name='home' type='submit' value='home'></a> 
      <a href='logout.php'><input name='logout' type='submit' value='logout'></a> 
      <a href='/adduser.php'><input name='add_user' type="submit" value='add a new user to this center'></a>
      
      <table width='100%' border='0' cellspacing='0' cellpadding='3'> <!-- this is to show all of the users-->
		<?php
			if($num_climbers > 0) //if there are more than 0 rows of links then it will run this code
		{

			while ($climber = mysql_fetch_array($climbers, MYSQL_ASSOC)){ // 

				echo'  
				<tr>
					<td width="150">' . $climber['real_name'] . '</t>
                    <td width="150"><form action="instructorpage.php" method="post" name="view_user">
                        <input name="view_user" type="submit" value="view this users profile">
                        <input type="hidden" name="user_id" value="'. $climber['user_id'] .'">
                    </form></t>
                    <td width="auto"><form action="instructorpage.php" method="post" name="delete_user">
                        <input name="delete_user" type="submit" value="delete user">
                    </form></t>
				</tr>
				'; 
			}
		}
		

		?>
	</table>
    
  </body>
</html>