<?php

// $connection = mysqli_connect('localhost', 'root', '');

$db_usuario="root";
$db_pass="DropBear321";
$db_nombre="EV";
$localhost="127.0.0.1";



// $localhost = "localhost";


$conn =  new mysqli($localhost,$db_usuario,$db_pass,$db_nombre);


if(!$conn){

        die("Database Connection Failed" . mysqli_error($conn));

}

else{

  // echo "<P>CONNECTED<P>";

  ini_set('display_errors', 0);

  error_reporting(E_ALL ^ E_WARNING);

 }

?>
