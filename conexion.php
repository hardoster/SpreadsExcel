<?php  
$mysqli = new mysqli('localhost', 'root', '', 'exactrack'); 

if($mysqli->connect_error){
    echo 'fallo la conexion ' . $mysqli->connect_error;
    die();
}

?>