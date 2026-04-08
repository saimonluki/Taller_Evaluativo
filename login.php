<?php
// Iniciamos la sesión para saber si el usuario ya está autenticado.
session_start();
if(isset($_SESSION['usuario_activo'])){
    // Si el usuario ya ingresó, lo enviamos directamente al panel principal.
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospital Pro</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="body-login page-login">

    <div class="login-caja">
        <i class="fa-solid fa-hospital-user icono-hospital"></i>
        <h2>Iniciar Sesión</h2>

        <form method="POST" action="controllers/AuthController.php">
            <label>Usuario</label>
            <input type="text" name="username" placeholder="Ingrese su usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <button type="submit" name="ingresar" class="btn-login">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Ingresar
            </button>
        </form>
    </div>

    <script src="assets/sweetalert2.js"></script>
    <script>
        const parametros = new URLSearchParams(window.location.search);
        if (parametros.get('status') === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado',
                text: 'Usuario o contraseña incorrectos',
                confirmButtonColor: '#3498db'
            });
        }
    </script>
</body>
</html>
