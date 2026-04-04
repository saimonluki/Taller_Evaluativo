<?php
session_start();
// El candado de seguridad
if(!isset($_SESSION['usuario_activo'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Módulo Insumos de Aseo</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

    <nav class="menu-navegacion">
        <ul class="menu-principal">
            <li>
                <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
            </li>
            
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-pen-to-square"></i> Gestión</a>
                <ul class="submenu">
                    <li><a href="views/insumos/agregar.php">Agregar Nuevo</a></li>
                    <li><a href="views/insumos/listado.php">Ver Listado</a></li>
                </ul>
            </li>

            <li>
                <a href="views/analisis.php"><i class="fa-solid fa-chart-pie"></i> Análisis</a>
            </li>

            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-file-lines"></i> Documentos</a>
                <ul class="submenu">
                    <li><a href="views/reporte.php">Reporte HTML</a></li>
                    <li><a href="views/descargar_pdf.php">Descargar PDF</a></li>
                </ul>
            </li>

            <li>
                <a href="logout.php" style="color: #ff6b6b;"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
            </li>
        </ul>
    </nav>

    <main class="contenido">
        <h1>¡Bienvenido/a, <?php echo $_SESSION['usuario_activo']; ?>!</h1>
        <p>Has ingresado al Módulo de Control de Insumos de Aseo del Hospital.</p>
        
        <br><br>
        <i class="fa-solid fa-pump-soap fa-5x" style="color: #4CAF50;"></i>
        <i class="fa-solid fa-broom fa-5x" style="color: #2196F3; margin-left: 20px;"></i>
    </main>

    <script src="assets/sweetalert2.js"></script>
</body>
</html>