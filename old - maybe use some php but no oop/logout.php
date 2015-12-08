<?php
session_start(); //starting the session	
session_destroy(); //deleting all of the current session so that the user can no longer access the restricted pages
header("Location: /index.php"); //redirecting to the index
?>