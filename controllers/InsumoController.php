<?php
// Importamos la conexión y el modelo
require_once '../config/conexion.php';
require_once '../models/insumo.php';

// ==========================================
// 1. ACCIÓN PARA GUARDAR
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'guardar') {
    
    $articulo = $_POST['articulo'];
    $cantidad = $_POST['cantidad'];
    $area_uso = $_POST['area_uso'];

    $modeloInsumo = new Insumo($conn);

    if ($modeloInsumo->registrar($articulo, $cantidad, $area_uso)) {
        header("Location: ../views/insumos/agregar.php?status=success");
        exit();
    } else {
        header("Location: ../views/insumos/agregar.php?status=error");
        exit();
    }
}

// ==========================================
// 2. ACCIÓN PARA ELIMINAR
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    
    // Recibimos el ID que mandó el botón desde listado.php
    $id = $_GET['id'];
    
    $modeloInsumo = new Insumo($conn);

    if ($modeloInsumo->eliminar($id)) {
        header("Location: ../views/insumos/listado.php?status=deleted");
        exit();
    } else {
        header("Location: ../views/insumos/listado.php?status=error");
        exit();
    }
}