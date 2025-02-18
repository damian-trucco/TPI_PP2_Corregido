<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_urquiza_actualizada";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Definir las carreras
$carreras = [
    "TÉCNICO SUPERIOR EN ANÁLISIS FUNCIONAL DE SISTEMAS INFORMÁTICOS",
    "TÉCNICO SUPERIOR EN DESARROLLO DE SOFTWARE",
    "TÉCNICO SUPERIOR EN INFRAESTRUCTURA DE TECNOLOGÍA DE LA INFORMACIÓN"
];

// Obtener los máximos de inscripción desde la base de datos
$max_inscripciones = [];
foreach ($carreras as $carrera) {
    $sql = "SELECT valor FROM configuracion WHERE clave = 'max_inscripciones_" . md5($carrera) . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_inscripciones[$carrera] = $row ? (int)$row['valor'] : 100; // Valor por defecto 100 si no hay configuración
}

// Obtener la cantidad de inscriptos en cada carrera
$inscritos = [];
foreach ($carreras as $carrera) {
    $sql_count = "SELECT COUNT(*) as total FROM pre_inscripcion WHERE carrera = '$carrera'";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $inscritos[$carrera] = $row_count['total'];
}

// Actualizar límites máximos si se envían desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($carreras as $carrera) {
        $clave = 'max_inscripciones_' . md5($carrera);
        if (isset($_POST[$clave])) {
            $nuevo_max = (int)$_POST[$clave];
            if ($nuevo_max > 0) {
                $conn->query("UPDATE configuracion SET valor = '$nuevo_max' WHERE clave = '$clave'");
                $max_inscripciones[$carrera] = $nuevo_max;
            }
        }
    }
}

// Obtener la lista de alumnos registrados
$sql = "SELECT * FROM pre_inscripcion ORDER BY ID_pre_inscripcion DESC";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumnos</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Registro de Alumnos</h1>

    <?php foreach ($carreras as $carrera): ?>
        <p><strong><?php echo $carrera; ?></strong> - Registrados: <strong><?php echo $inscritos[$carrera]; ?></strong> / Máximo: <strong><?php echo $max_inscripciones[$carrera]; ?></strong></p>
    <?php endforeach; ?>

    <form method="post">
        <h2>Establecer máximos de inscripción</h2>
        <?php foreach ($carreras as $carrera): ?>
            <label for="<?php echo md5($carrera); ?>"><?php echo $carrera; ?>:</label>
            <input type="number" name="<?php echo 'max_inscripciones_' . md5($carrera); ?>" value="<?php echo $max_inscripciones[$carrera]; ?>" required>
            <br>
        <?php endforeach; ?>
        <button type="submit">Actualizar</button>
    </form>

    <h2>Lista de Alumnos Preinscritos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Documento</th>
            <th>Domicilio</th>
            <th>Email</th>
            <th>Carrera</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['ID_pre_inscripcion']; ?></td>
            <td><?php echo $row['Nombre']; ?></td>
            <td><?php echo $row['Apellido']; ?></td>
            <td><?php echo $row['Documento']; ?></td>
            <td><?php echo $row['Domicilio']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['carrera']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let carreras = <?php echo json_encode($carreras); ?>;
            let inscritos = <?php echo json_encode($inscritos); ?>;
            let maximos = <?php echo json_encode($max_inscripciones); ?>;
            
            carreras.forEach(function(carrera) {
                if (inscritos[carrera] >= maximos[carrera]) {
                    let mensaje = document.createElement("p");
                    mensaje.style.color = "red";
                    mensaje.style.fontWeight = "bold";
                    mensaje.innerText = "Se ha alcanzado el límite de inscripciones para " + carrera + ". No se aceptan más registros.";
                    document.body.appendChild(mensaje);
                }
            });
        });
    </script>

</body>
</html>
