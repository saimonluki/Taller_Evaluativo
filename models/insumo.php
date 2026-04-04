<?php
// Modelo que maneja los insumos de aseo y las consultas a la base de datos.
class Insumo {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Registra un nuevo insumo usando el procedimiento almacenado.
    public function registrar($articulo, $cantidad, $area_uso) {
        $sql = "CALL sp_insertar_insumo('$articulo', $cantidad, '$area_uso')";
        return $this->conn->query($sql);
    }

    // Obtiene todos los insumos para mostrar en el listado.
    public function listar() {
        $sql = "SELECT * FROM insumos_aseo";
        return $this->conn->query($sql);
    }

    // Función para eliminar un insumo por su ID
    public function eliminar($id) {
        $sql = "DELETE FROM insumos_aseo WHERE id_aseo = $id";
        return $this->conn->query($sql);
    }
    // Función para gráfica de Barras y Líneas (Agrupado por artículo)
    public function datosPorArticulo() {
        $sql = "SELECT articulo, SUM(cantidad) as total FROM insumos_aseo GROUP BY articulo";
        return $this->conn->query($sql);
    }

    // Función para gráfica de Pastel (Agrupado por área de uso)
    public function datosPorArea() {
        $sql = "SELECT area_uso, SUM(cantidad) as total FROM insumos_aseo GROUP BY area_uso";
        return $this->conn->query($sql);
    }
}
?>