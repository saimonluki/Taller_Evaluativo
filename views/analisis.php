<?php
// Verificamos sesión antes de mostrar la página de análisis.
session_start();
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../login.php");
    exit();
}

require_once '../config/conexion.php';
require_once '../models/Insumo.php';

$modelo = new Insumo($conn);

// Obtenemos los datos necesarios para las gráficas.
$datosArticulos = $modelo->datosPorArticulo();
$datosAreas = $modelo->datosPorArea();

// Convertimos los resultados en arreglos que usa Chart.js.
$nombresArticulos = [];
$cantidadesArticulos = [];
while($row = $datosArticulos->fetch_assoc()) {
    $nombresArticulos[] = $row['articulo'];
    $cantidadesArticulos[] = $row['total'];
}

$nombresAreas = [];
$cantidadesAreas = [];
while($row = $datosAreas->fetch_assoc()) {
    $nombresAreas[] = $row['area_uso'];
    $cantidadesAreas[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis de Insumos</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <style>
        .contenedor-graficas {
            display: flex; flex-wrap: wrap; justify-content: space-around; margin-top: 20px;
        }
        .grafica-caja {
            background: white; padding: 20px; border-radius: 10px; 
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1); width: 45%; margin-bottom: 20px;
            text-align: center;
        }
        .grafica-caja.completa { width: 95%; } 
    </style>
</head>
<body>

    <nav class="menu-navegacion">
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
        <h1>Análisis Estadístico</h1>
        <p>Visualización del inventario de aseo.</p>

        <div class="contenedor-graficas">
            <div class="grafica-caja">
                <h3>Cantidad por Artículo (Área)</h3>
                <canvas id="graficaArea"></canvas>
            </div>

            <div class="grafica-caja">
                <h3>Tendencia de Artículos (Líneas)</h3>
                <canvas id="graficaLineas"></canvas>
            </div>

            <div class="grafica-caja completa">
                <h3>Distribución por Área de Uso (Torta)</h3>
                <canvas id="graficaTorta" style="max-height: 350px;"></canvas>
            </div>
        </div>
    </main>

    <script src="../assets/chart.js"></script>

    <script>
        const nombresArticulos = <?php echo json_encode($nombresArticulos); ?>;
        const cantidadesArticulos = <?php echo json_encode($cantidadesArticulos); ?>;
        const nombresAreas = <?php echo json_encode($nombresAreas); ?>;
        const cantidadesAreas = <?php echo json_encode($cantidadesAreas); ?>;

        // Colores base para los gráficos.
        const colorPlata = '#C0C0C0';
        const colorPlataTransparente = 'rgba(192, 192, 192, 0.5)';

        // Gráfica de área: muestra la tendencia con relleno suave.
        new Chart(document.getElementById('graficaArea'), {
            type: 'line',
            data: {
                labels: nombresArticulos,
                datasets: [{
                    label: 'Unidades Disponibles',
                    data: cantidadesArticulos,
                    backgroundColor: colorPlataTransparente,
                    borderColor: colorPlata,
                    borderWidth: 2,
                    fill: true
                }]
            }
        });

        // 2. GRÁFICA DE LÍNEAS 
        new Chart(document.getElementById('graficaLineas'), {
            type: 'line',
            data: {
                labels: nombresArticulos,
                datasets: [{
                    label: 'Unidades Disponibles',
                    data: cantidadesArticulos,
                    backgroundColor: colorPlata,
                    borderColor: colorPlata,
                    borderWidth: 2,
                    fill: false 
                }]
            }
        });

        // 3. GRÁFICA DE TORTA (Pastel)
        new Chart(document.getElementById('graficaTorta'), {
            type: 'pie',
            data: {
                labels: nombresAreas,
                datasets: [{
                    data: cantidadesAreas,
                    backgroundColor: colorPlata, 
                    borderColor: '#ffffff',     
                    borderWidth: 3               
                }]
            }
        });
    </script>
</body>
</html>