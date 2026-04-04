<?php
// Clase que maneja los usuarios y la validación de credenciales.
class Usuario {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Verifica el usuario y la contraseña contra el procedimiento almacenado en la base de datos.
    public function verificarCredenciales($username, $password) {
        $user = $this->conn->real_escape_string($username);
        $pass = $this->conn->real_escape_string($password);

        // Llamamos al procedimiento de validación
        $sql = "CALL sp_validar_usuario('$user', '$pass')";
        $resultado = $this->conn->query($sql);

        // Si encontró resultados, devuelve los datos. Si no, devuelve falso.
        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_assoc(); 
        } else {
            return false;
        }
    } // <-- Aquí se cierra la función
} // <-- Aquí se cierra la clase
?>