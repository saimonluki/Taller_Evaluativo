<?php
// Configuración de acceso a la base de datos. Este archivo se incluye desde los modelos y controladores.
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "hospital_pro";

// Establecemos la conexión usando la extensión mysqli.
$conn = new mysqli($host, $usuario, $password, $base_datos);

// Detenemos el script si la conexión falla.
if ($conn->connect_error) {
    die("Ups, algo salió mal con la conexión: " . $conn->connect_error);
}

// Usamos UTF-8 para que el sistema maneje bien los acentos y caracteres especiales.
$conn->set_charset("utf8");
?>