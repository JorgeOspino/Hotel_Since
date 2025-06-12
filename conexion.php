<?php

$host = 'localhost';  
$usuario = 'root';  
$contrasena = 'Jospi2512';     
$base_de_datos = 'hotel_san_luis';  


$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} 
?>
