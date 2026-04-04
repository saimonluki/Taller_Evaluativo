<?php
session_start();
// Candado de seguridad
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../login.php");
    exit();
}

// 1. Traemos la conexión y el modelo
require_once '../config/conexion.php';
require_once '../models/Insumo.php';

// 2. Incluimos la librería Dompdf que acabas de descargar
require_once '../assets/dompdf/autoload.inc.php';

// Le decimos a PHP que vamos a usar la clase Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

$modelo = new Insumo($conn);
$resultado = $modelo->listar(); 

// 3. Empezamos a armar el diseño (HTML) que irá dentro del PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .encabezado { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .encabezado h1 { color: #2c3e50; margin: 0; }
        .encabezado p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: center; }
        th { background-color: #ecf0f1; }
    </style>
</head>
<body>
    <div class="encabezado">
        <h1>Hospital Pro</h1>
        <p>Reporte Oficial del Inventario de Aseo</p>
        <p>Generado por: <strong>' . $_SESSION['usuario_activo'] . '</strong> | Fecha: ' . date("d/m/Y") . '</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Artículo</th>
                <th>Cantidad</th>
                <th>Área Asignada</th>
            </tr>
        </thead>
        <tbody>';

// 4. Llenamos la tabla con los datos de la base de datos
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $fila['id_aseo'] . '</td>
                    <td>' . $fila['articulo'] . '</td>
                    <td>' . $fila['cantidad'] . '</td>
                    <td>' . $fila['area_uso'] . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="4">No hay insumos registrados</td></tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// 5. Configuramos y generamos el PDF
$opciones = new Options();
$opciones->set('isHtml5ParserEnabled', true); // Permitir HTML moderno
$opciones->set('isRemoteEnabled', true);      // Permitir cargar imágenes si las hubiera

// Instanciamos Dompdf
$dompdf = new Dompdf($opciones);

// Le pasamos nuestro diseño HTML
$dompdf->loadHtml($html);

// Configuramos el tamaño del papel (A4) y la orientación (portrait = vertical)
$dompdf->setPaper('A4', 'portrait');

// Renderizamos (convertimos a PDF en la memoria del servidor)
$dompdf->render();

// 6. Forzamos la descarga del archivo al usuario
$dompdf->stream("Reporte_Insumos_Hospital.pdf", array("Attachment" => true)); 
// Nota: Si cambias "true" por "false", el PDF se abrirá en el navegador en vez de descargarse directamente.
?>