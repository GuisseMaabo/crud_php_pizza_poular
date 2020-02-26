<?php
// connect to database 
 $conn = mysqli_connect('localhost','cire','cire','pizza_poular');
 // check the connection
 if (!$conn) {

 	echo "Connection Error:". mysqli_connect_error();
 }