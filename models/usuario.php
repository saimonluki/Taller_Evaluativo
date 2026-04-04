<?php
class Usuario {
    private $conn;

    // Cuando llamemos a esta clase, le pasaremos la conexión a la base de datos
    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Esta función busca al usuario usando el Procedimiento Almacenado
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