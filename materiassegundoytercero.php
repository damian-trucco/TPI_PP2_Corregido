<?php

require_once './data_base/db_urquiza.php';

if (isset($_GET['carrera_id'])) {
    $carrera_id = $_GET['carrera_id'];

    $sql = "SELECT nombre FROM carreras WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$carrera_id]);
    $carrera = $stmt->fetch();

    $sql = "SELECT * FROM materias WHERE carrera_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$carrera_id]);
    $materias = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Disponibles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 75%;
        }

        h1 {
            color: #333;
        }

        .materia {
            margin-bottom: 10px;
        }

        .year-container {
            border: 2px solid #333;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .year-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        aside {
            width: 25%;
            margin-left: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        aside img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Seleccione las materias que desea cursar/recursar - <?php echo $carrera['nombre']; ?></h1>
        <form action="inscribir.php" method="POST">
            <input type="hidden" name="carrera_id" value="<?php echo $carrera_id; ?>">

            <?php
            $years = [1 => 'Primer año', 2 => 'Segundo año', 3 => 'Tercer año'];
            foreach ($years as $year => $year_title) {
                $filtered_materias = array_filter($materias, function ($materia) use ($year) {
                    return $materia['anio'] == $year;
                });
                if (count($filtered_materias) > 0) {
                    echo "<div class='year-container'>";
                    echo "<div class='year-title'>{$year_title}</div>";
                    foreach ($filtered_materias as $materia) {
                        echo "<div class='materia'>";
                        echo "<input type='checkbox' name='materias[]' value='{$materia['id']}'>";
                        echo "{$materia['nombre']} (Año {$materia['anio']})";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
            ?>

            <br>
            <input type="submit" value="Inscribirse">
        </form>
    </div>

    <aside>
        <?php if ($carrera_id == 1) { ?>
            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/image-2.png" alt="Analista Funcional">
        <?php } elseif ($carrera_id == 2) { ?>
            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/image-3.png" alt="Desarrollador de Software">
        <?php } elseif ($carrera_id == 3) { ?>
            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/image-4.png" alt="Infraestructura en TI">
        <?php } ?>
    </aside>
</body>

</html>