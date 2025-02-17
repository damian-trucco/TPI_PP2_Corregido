<?php
$host = "localhost";  // Servidor MySQL (ajusta según sea necesario)
$usuario = "root";    // Usuario de la base de datos
$clave = "";          // Contraseña de la base de datos (déjala vacía si no tienes)
$bd = "db_urquiza_actualizada"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>