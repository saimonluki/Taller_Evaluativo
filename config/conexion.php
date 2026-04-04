<?php
// 1. Definimos las variables de conexión
$host = "localhost";
$usuario = "root";       
$password = "";          
$base_datos = "hospital_pro";

// 2. Creamos la conexión usando mysqli (¡La forma más fácil de sustentar!)
$conn = new mysqli($host, $usuario, $password, $base_datos);

// 3. Verificamos si hubo algún error al conectar
if ($conn->connect_error) {
    die("Ups, algo salió mal con la conexión: " . $conn->connect_error);
}

// 4. Configuramos el tipo de caracteres para evitar problemas con tildes
$conn->set_charset("utf8");
?>