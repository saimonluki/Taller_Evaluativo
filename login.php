<?php
session_start();
if(isset($_SESSION['usuario_activo'])){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Hospital Pro</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="body-login"> <div class="login-caja"> <i class="fa-solid fa-hospital-user icono-hospital"></i>
        <h2>Iniciar Sesión</h2>
        
        <form method="POST" action="controllers/AuthController.php">
            <label>Usuario</label>
            <input type="text" name="username" placeholder="Ingrese su usuario" required>
            
            <label>Contraseña</label>
            <input type="password" name="password" placeholder="********" required>
            
            <button type="submit" name="ingresar" class="btn-login">Ingresar</button>
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