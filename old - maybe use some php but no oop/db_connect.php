<?php
DEFINE ('DB_USER','root');
DEFINE ('DB_PASSWORD','pVvEmrVj6afyTp75');
DEFINE ('DB_HOST','localhost');
DEFINE ('DB_NAME','climb_log');

//make the connection to MySQL
$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL: ' . mysql_error() );

//select the specific database
@mysql_select_db (DB_NAME) OR die ('Could not select the database: ' . mysql_error() );
?>