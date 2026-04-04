<?php
session_start();
// Importamos la conexión y el modelo
require_once '../config/conexion.php';
require_once '../models/usuario.php';

// Verificamos si se presionó el botón de ingresar
if (isset($_POST['ingresar'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Instanciamos el modelo de Usuario
    $modeloUsuario = new Usuario($conn);
    
    // Le pedimos al modelo que verifique las credenciales
    $usuarioLogueado = $modeloUsuario->verificarCredenciales($username, $password);

    if ($usuarioLogueado) {
        // Si todo es correcto, creamos el "gafete virtual" (sesión)
        $_SESSION['usuario_activo'] = $usuarioLogueado['nombre_completo'];
        $_SESSION['rol_activo'] = $usuarioLogueado['fk_rol'];
        
        // Redirigimos a la raíz (index.php)
        header("Location: ../index.php");
        exit();
    } else {
        // Si falla, lo devolvemos al login con un aviso en la URL
        header("Location: ../login.php?status=error");
        exit();
    }
}
?>