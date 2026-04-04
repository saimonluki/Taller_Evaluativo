<?php
// Página que muestra la tabla con todos los insumos registrados.
session_start();
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../../login.php");
    exit();
}

require_once '../../config/conexion.php';
require_once '../../models/Insumo.php';

$modeloInsumo = new Insumo($conn);
$resultado = $modeloInsumo->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Insumos</title>
    <link rel="stylesheet" href="../../assets/css/all.min.css"> 
    <link rel="stylesheet" href="../../assets/css/estilos.css"> 
</head>
<body>

    <nav class="menu-navegacion">
        <ul class="menu-principal">
            <li><a href="../../index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-pen-to-square"></i> Gestión</a>
                <ul class="submenu">
                    <li><a href="agregar.php">Agregar Nuevo</a></li>
                    <li><a href="listado.php">Ver Listado</a></li>
                </ul>
            </li>
            <li><a href="../analisis.php"><i class="fa-solid fa-chart-pie"></i> Análisis</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-file-lines"></i> Documentos</a>
                <ul class="submenu">
                    <li><a href="../reporte.php">Reporte HTML</a></li>
                    <li><a href="../descargar_pdf.php">Descargar PDF</a></li>
                </ul>
            </li>
            <li><a href="../../logout.php" style="color: #ff6b6b;"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

    <main class="contenido">
        <h1>Listado de Insumos de Aseo</h1>
        
        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Área de Uso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ciclo para imprimir los datos de la base de datos en la tabla
                    if ($resultado->num_rows > 0) {
                        while($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $fila['id_aseo'] . "</td>";
                            echo "<td>" . $fila['articulo'] . "</td>";
                            echo "<td>" . $fila['cantidad'] . "</td>";
                            echo "<td>" . $fila['area_uso'] . "</td>";
                            echo "<td>
                                    <a href='#' class='btn-editar'><i class='fa-solid fa-pen'></i></a>
                                    <button onclick='confirmarBorrado(" . $fila['id_aseo'] . ")' class='btn-borrar'><i class='fa-solid fa-trash'></i></button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay insumos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../../assets/sweetalert2.js"></script>

    <script>
        // Mensaje de éxito al borrar
        const parametros = new URLSearchParams(window.location.search);
        if (parametros.get('status') === 'deleted') {
            Swal.fire('¡Borrado!', 'El registro ha sido eliminado.', 'success');
        }

        // ALERTA 4: ¿Estás seguro? (Color amarillo)
        function confirmarBorrado(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Si borras esto, desaparecerá para siempre",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((resultado) => {
                if (resultado.isConfirmed) {
                    window.location.href = '../../controllers/InsumoController.php?action=eliminar&id=' + id;
                }
            });
        }
    </script>
</body>
</html>