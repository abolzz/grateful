<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'grateful');

/*
define('DB_SERVER', 'davisabols.dk.mysql');
define('DB_USERNAME', 'davisabols_dk');
define('DB_PASSWORD', 'c6sbyB7GvkfiHkJy7te9do26');
define('DB_NAME', 'davisabols_dk');



define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'grateful_grateful');
define('DB_PASSWORD', 'Lebron2-3');
define('DB_NAME', 'grateful_grateful');
*/

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

/*
// sql to create table
$createtable = "CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(30) NOT NULL,
username VARCHAR(30) NOT NULL,
password VARCHAR(255) NOT NULL,
activationkey VARCHAR(255) NOT NULL,
activated TINYINT(1),
reg_date TIMESTAMP
)";


if ($link->query($createtable) === TRUE) {

} else {
    
}
*/
?>
