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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Insumos</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body class="page-reports">

    <nav class="menu-navegacion">
        <ul class="menu-principal">
            <li><a href="../index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-pen-to-square"></i> Gestión <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.7;"></i></a>
                <ul class="submenu">
                    <li><a href="insumos/agregar.php">Agregar Nuevo</a></li>
                    <li><a href="insumos/listado.php">Ver Listado</a></li>
                </ul>
            </li>
            <li><a href="analisis.php"><i class="fa-solid fa-chart-pie"></i> Análisis</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-file-lines"></i> Documentos <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.7;"></i></a>
                <ul class="submenu">
                    <li><a href="reporte.php">Reporte HTML</a></li>
                    <li><a href="descargar_pdf.php">Descargar PDF</a></li>
                </ul>
            </li>
            <li><a href="../logout.php" style="color: #e57373;"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

    <main class="contenido">
        <h1>Análisis Estadístico</h1>
        <p>Visualización del inventario de aseo por artículo y área.</p>

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
