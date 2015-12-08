<?php

session_start();	//this starts the session


if(!$_SESSION['logged_in_user']){  //checking if session is logged in
	header("Location: /index.php"); // re-directs if not logged in
}

require_once ('db_connect.php');
$center_id = $_SESSION['center_id']; //getting the center id of the logged in user
$user_id = $_SESSION['user_id'];

$sql_define_1 = "SELECT * FROM logs WHERE user_id = $user_id"; //assigning the sql statement
$logs = mysql_query($sql_define_1); // running the sql statement
$num_logs = mysql_num_rows($logs); //counting the rows for later
    
?>

<!DOCTYPE html>
<html>

  <head>
    
    <title> climlog - no formatting </title>
    
  </head>
  
  <body>
      <a href='logout.php'><input type="submit" value='logout'></a>
      <?php

        if($_SESSION['logged_in_instructor']){  //checking if session is logged in
           echo'<a href="instructorpage.php"><input type="submit" value="instructor page"></a>'; 
        }
      
      ?>
      <a href='index.php'><input type="submit" value='home'></a>
      
      
      
      <table width='100%' border='0' cellspacing='0' cellpadding='3'> <!-- this is to show all of the logs-->
		<?php
			if($num_logs > 0) //if there are more than 0 rows of links then it will run this code
		{

			while ($log = mysql_fetch_array($logss, MYSQL_ASSOC)){ // 

				echo'  
				<tr>
					<td width="150">' . $log['real_name'] . '</t>
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