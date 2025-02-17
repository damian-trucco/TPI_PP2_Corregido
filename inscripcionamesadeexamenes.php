<?php

require_once './data_base/db_urquiza.php';

// Obtener la carrera seleccionada (por defecto 'Analista Funcional' con ID 1)
$carrera_id = isset($_GET['carrera_id']) ? $_GET['carrera_id'] : 1;

// Consultar nombre de la carrera
$sql = "SELECT nombre FROM carreras WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$carrera_id]);
$carrera = $stmt->fetch();

// Consultar materias de la carrera seleccionada con fechas de examen (simulación de fechas en este caso)
$sql = "SELECT * FROM materias WHERE carrera_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$carrera_id]);
$materias = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Mesas de Examen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 80%;
        }

        h1 {
            color: #333;
        }

        .selector-container {
            margin-bottom: 20px;
        }

        .selector-container select {
            padding: 5px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        .inscribirse-btn {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .inscribirse-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inscripción a Mesas de Examen</h1>

        <!-- Selector de carrera -->
        <div class="selector-container">
            <form action="" method="GET">
                <label for="carrera">Carrera:</label>
                <select name="carrera_id" id="carrera" onchange="this.form.submit()">
                    <option value="1" <?= $carrera_id == 1 ? 'selected' : '' ?>>Analista Funcional</option>
                    <option value="2" <?= $carrera_id == 2 ? 'selected' : '' ?>>Desarrollador de Software</option>
                    <option value="3" <?= $carrera_id == 3 ? 'selected' : '' ?>>Infraestructura en TI</option>
                </select>
            </form>
        </div>

        <h2><?php echo $carrera['nombre']; ?></h2>

        <!-- Tabla de materias con fechas de examen -->
        <table>
            <tr>
                <th>Materia</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Acción</th>
            </tr>
            <?php
            if (!empty($materias)) {
                foreach ($materias as $materia) {
                    // Simulación de fecha y horario (esto debería venir de la base de datos)
                    $fecha_examen = date("d/m/Y", strtotime("+".rand(1, 30)." days"));
                    $horario_examen = rand(8, 20) . ":00";

                    echo "<tr>";
                    echo "<td>{$materia['nombre']}</td>";
                    echo "<td>{$fecha_examen}</td>";
                    echo "<td>{$horario_examen} hs</td>";
                    echo "<td>
                            <form action='inscribir_examen.php' method='POST'>
                                <input type='hidden' name='materia_id' value='{$materia['id']}'>
                                <input type='hidden' name='fecha' value='{$fecha_examen}'>
                                <input type='hidden' name='horario' value='{$horario_examen}'>
                                <button type='submit' class='inscribirse-btn'>Inscribirse</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay materias disponibles.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
