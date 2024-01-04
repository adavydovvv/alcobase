<?php
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'Alcobase');
$connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
mysqli_set_charset($connect, "utf8");
?>