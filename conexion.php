<?php
$host = "localhost";  // Servidor MySQL
$usuario = "root";    // Usuario de la base de datos
$clave = "";          // Contraseña de la base de datos
$bd = "db_urquiza_actualizada"; // Nombre de la base de datos

// Función para obtener conexión a la base de datos
function obtenerConexion() {
    global $host, $usuario, $clave, $bd;

    // Activar reportes de errores en MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn = new mysqli($host, $usuario, $clave, $bd);
        $conn->set_charset("utf8mb4"); // Establecer el conjunto de caracteres
        return $conn;
    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Crear conexión global (si es necesario)
$conn = obtenerConexion();
?>
