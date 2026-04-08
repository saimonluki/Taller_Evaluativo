<?php
// Página para registrar un nuevo insumo en el inventario.
session_start();
if(!isset($_SESSION['usuario_activo'])){
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Insumo</title>
    <link rel="stylesheet" href="../../assets/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body class="page-insumos">

    <nav class="menu-navegacion">
        <ul class="menu-principal">
            <li><a href="../../index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-pen-to-square"></i> Gestión <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.7;"></i></a>
                <ul class="submenu">
                    <li><a href="agregar.php">Agregar Nuevo</a></li>
                    <li><a href="listado.php">Ver Listado</a></li>
                </ul>
            </li>
            <li><a href="../analisis.php"><i class="fa-solid fa-chart-pie"></i> Análisis</a></li>
            <li class="con-submenu">
                <a href="#"><i class="fa-solid fa-file-lines"></i> Documentos <i class="fa-solid fa-chevron-down" style="font-size:10px;opacity:.7;"></i></a>
                <ul class="submenu">
                    <li><a href="../reporte.php">Reporte HTML</a></li>
                    <li><a href="../descargar_pdf.php">Descargar PDF</a></li>
                </ul>
            </li>
            <li><a href="../../logout.php" style="color: #e57373;"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
    </nav>

    <main class="contenido">
        <h1>Agregar Nuevo Insumo</h1>
        <p>Completa los datos para registrar un insumo de aseo.</p>

        <div class="formulario-caja">
            <form id="formInsumos" method="POST" action="../../controllers/InsumoController.php?action=guardar">
                <label>Nombre del Artículo</label>
                <input type="text" id="articulo" name="articulo" placeholder="Ej. Jabón Líquido">

                <label>Cantidad</label>
                <input type="text" id="cantidad" name="cantidad" placeholder="Ej. 15">

                <label>Área de Uso</label>
                <input type="text" id="area_uso" name="area_uso" placeholder="Ej. Quirófano">

                <button type="submit" name="btn_guardar" class="btn-guardar">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Insumo
                </button>
            </form>
        </div>
    </main>

    <script src="../../assets/sweetalert2.js"></script>

    <script>
        // 1. DISPARAR ALERTA SEGÚN LA URL (Viene del Controlador)
        const parametros = new URLSearchParams(window.location.search);
        if (parametros.get('status') === 'success') {
            Swal.fire({ icon: 'success', title: '¡Guardado!', text: 'El insumo se registró correctamente en la base de datos.' });
        } else if (parametros.get('status') === 'error') {
            Swal.fire({ icon: 'error', title: '¡Error!', text: 'Ocurrió un problema al guardar los datos.' });
        }

        // 2. VALIDACIONES ANTES DE ENVIAR EL FORMULARIO (Checklist)
        document.getElementById('formInsumos').addEventListener('submit', function(evento) {
            let articulo = document.getElementById('articulo').value;
            let cantidad = document.getElementById('cantidad').value;
            let area_uso = document.getElementById('area_uso').value;

            // Validación: Campos vacíos
            if(articulo.trim() === '' || cantidad.trim() === '' || area_uso.trim() === '') {
                evento.preventDefault(); // Evita que el formulario se envíe
                Swal.fire({ icon: 'warning', title: '¡Campos Vacíos!', text: 'Por favor, llena todos los campos antes de guardar.' });
            } 
            // Validación: Solo números en la cantidad
            else if(isNaN(cantidad)) {
                evento.preventDefault(); 
                Swal.fire({ icon: 'error', title: '¡Dato Incorrecto!', text: 'La cantidad debe ser un número, no letras.' });
            }
        });
    </script>
</body>
</html>
