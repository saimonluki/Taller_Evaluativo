<?php
session_start();
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../login.php");
    exit();
}

// 1. Traemos la conexión y el modelo
require_once '../config/conexion.php';
require_once '../models/Insumo.php';

$modelo = new Insumo($conn);
$resultado = $modelo->listar(); // Reutilizamos la función que ya teníamos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Insumos</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <style>
        /* Estilos específicos para que el reporte se vea formal */
        .reporte-contenedor { width: 80%; margin: 20px auto; background: white; padding: 40px; box-shadow: 0px 0px 15px rgba(0,0,0,0.2); }
        .encabezado-reporte { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .encabezado-reporte h2 { color: #2c3e50; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 12px; text-align: center; }
        th { background-color: #ecf0f1; color: #333; }
        
        .btn-imprimir { background-color: #34495e; color: white; padding: 10px 20px; border: none; font-size: 16px; cursor: pointer; border-radius: 5px; margin-bottom: 20px; }
        .btn-imprimir:hover { background-color: #2c3e50; }

        /* =========================================
           LA MAGIA DE LA IMPRESIÓN (Para tu sustentación)
           Todo lo que tenga la clase "no-imprimir" desaparecerá en el papel
           ========================================= */
        @media print {
            .no-imprimir { display: none !important; }
            .menu-navegacion { display: none !important; }
            body { background-color: white; }
            .reporte-contenedor { box-shadow: none; width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

    <nav class="menu-navegacion no-imprimir">
        <ul class="menu-principal">
            <li><a href="../index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-pen-to-square"></i> Gestión</a>
                <ul class="submenu">
                    <li><a href="insumos/agregar.php">Agregar Nuevo</a></li>
                    <li><a href="insumos/listado.php">Ver Listado</a></li>
                </ul>
            </li>
            <li><a href="analisis.php"><i class="fa-solid fa-chart-pie"></i> Análisis</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-file-lines"></i> Documentos</a>
                <ul class="submenu">
                    <li><a href="reporte.php">Reporte HTML</a></li>
                    <li><a href="descargar_pdf.php">Descargar PDF</a></li>
                </ul>
            </li>
            <li><a href="../logout.php" style="color: #ff6b6b;"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

    <main class="contenido">
        
        <button onclick="window.print()" class="btn-imprimir no-imprimir">
            <i class="fa-solid fa-print"></i> Imprimir Documento
        </button>

        <div class="reporte-contenedor">
            <div class="encabezado-reporte">
                <h2><i class="fa-solid fa-hospital"></i> Hospital Pro</h2>
                <h3>Reporte Oficial del Inventario de Aseo</h3>
                <p>Generado por: <strong><?php echo $_SESSION['usuario_activo']; ?></strong> | Fecha: <strong><?php echo date("d/m/Y"); ?></strong></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Artículo</th>
                        <th>Cantidad Disponible</th>
                        <th>Área Asignada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado->num_rows > 0) {
                        while($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $fila['id_aseo'] . "</td>";
                            echo "<td>" . $fila['articulo'] . "</td>";
                            echo "<td>" . $fila['cantidad'] . "</td>";
                            echo "<td>" . $fila['area_uso'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay insumos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>