<?php 

// mysqli-PDO (12) DATA BASES/lugaralojado(ip) 
$conn = new mysqli("localhost", "root", "root", "uptask"); //* Crea una coneccion con la base de datos 

if($conn->connect_error){
echo $conn->connect_error;
}
// si no se meustran los caracteres de español al consultar basta con esto

$conn->set_charset("utf8");