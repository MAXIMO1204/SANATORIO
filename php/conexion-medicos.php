<?php 
session_start();
// Conexión a la base de datos de médicos
$conexion_medicos = mysqli_connect("localhost", "root", "maximo2213", "profesionales");

if (!$conexion_medicos) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
