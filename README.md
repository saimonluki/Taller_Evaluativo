# 🏥 Sistema de Gestión de Insumos - Hospital Pro

Este es un proyecto web desarrollado bajo el patrón **MVC (Modelo-Vista-Controlador)** para la administración de inventarios hospitalarios.

## 🚀 Características
- **Autenticación segura:** Login con sesiones de PHP.
- **Base de Datos Pro:** Uso de **Procedimientos Almacenados** en MySQL.
- **Análisis Visual:** Gráficas dinámicas con **Chart.js**.
- **Reportes:** Generación de documentos e impresión de inventarios.
- **Diseño Moderno:** Interfaz limpia con CSS3 y SweetAlert2.

## 🛠️ Tecnologías utilizadas
- PHP / MySQL
- CSS3 (Flexbox & Grid)
- JavaScript / Chart.js
- Git / GitHub

## 📊 Módulo de análisis
- `views/analisis.php` genera gráficos con los datos de inventario.
- Se muestran cantidades por artículo y distribución por área de uso.
- El modelo `models/Insumo.php` provee los datos para Chart.js.

## 🧩 Estructura del código
- `login.php` / `logout.php`: acceso al sistema y cierre de sesión.
- `index.php`: panel principal protegido para el usuario autenticado.
- `controllers/AuthController.php`: procesa el ingreso y crea la sesión.
- `controllers/InsumoController.php`: guarda y elimina insumos.
- `models/usuario.php` y `models/insumo.php`: lógica de datos para usuarios e insumos.
- `views/`: interfaces y reportes que usa el sistema.
