<?php

require_once './data_base/db_urquiza.php';

if ($conexion) {
    $sql = "SELECT * FROM carreras";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC); // Asegúrate de obtener un array asociativo
} else {
    $carreras = [];
    $error_message = 'No se pudo establecer conexión con la base de datos.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Carreras</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="my-logo">
            <img src="https://encrypted-tbn2.gstatic.com/faviconV2?url=https://terciariourquiza.edu.ar&client=VFE&size=64&type=FAVICON&fallback_opts=TYPE,SIZE,URL&nfrp=2" alt="urquiza logo">
            <p>Escuela Superior Nº 49<br>Capitán General Justo José de Urquiza<br>Nivel Terciario</p>
        </div>
        <nav>
            <a href="./index.php" class="nav-link">Inicio</a>
            <a href="#calendario" class="nav-link">Calendario académico</a>
            <a href="login.php" class="nav-link">Iniciar sesión</a>
            <a href="#contacto" class="nav-link">Contacto</a>
        </nav>
    </header>

    <div id="search-box">
        <input type="text" placeholder="Buscar...">
    </div>

    <section class="urquiza-background">
        <h1>Alumnado</h1>
    </section>

    <main>
        <aside class="left-aside">
            <h2>Nuestras carreras y sus planes de estudio</h2>
            <?php if (isset($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
            <?php } ?>
            <?php if (!empty($carreras)) { ?>
                <?php foreach ($carreras as $carrera) { ?>
                    <div class="carrera">
                        <?php if ($carrera['id'] == 1) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_af_solo_chico-2.jpg" alt="Logo de Analista Funcional">
                        <?php } elseif ($carrera['id'] == 2) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_ds_solo_chico.jpg" alt="Logo de Desarrollo de Software">
                        <?php } elseif ($carrera['id'] == 3) { ?>
                            <img src="https://terciariourquiza.edu.ar/wp-content/uploads/2023/08/j_iti_solo_chico.jpg" alt="Logo de Infraestructura en TI">
                        <?php } ?>
                        <a href="materias.php?carrera_id=<?php echo $carrera['id']; ?>"><?php echo htmlspecialchars($carrera['nombre']); ?></a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No hay carreras disponibles en este momento.</p>
            <?php } ?>
        </aside>

        <section>
            <h1>Bienvenidos al Modulo de Alumnado</h1>
            <p>Para inscribirte a las materias que deseas cursar en el año academico vigente, selecciona la carrera a la que estas inscripto a la izquierda para ver las materias disponibles y comenzar con el proceso de inscripción.</p>
            <a href="preinscripcion.php" class="inscripcion-link">INSCRIPCIÓN A CARRERAS DE NIVEL TERCIARIO</a>
        </section>

        <aside class="right-aside">
            <h2>Calendario 20XX</h2>
            <ul class="noticias">
                <li>
                    <h3>Inscripción a materias</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
                <li>
                    <h3>Presentación de documentación requerida para inscripción a carreras</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
                <li>
                    <h3>Presentación de documentación para homologaciones</h3>
                    <p>Desde xx/xx/xxxx hasta xx/xx/xxxx</p>
                </li>
            </ul>
        </aside>
    </main>

    <footer id="contacto">
        <h2>CONTACTO</h2>
        <hr>Bv. Oroño 690 - Rosario<br>info@terciariourquiza.edu.ar<br>(0341) 4721430<br>(0341) 4721431<br>Horarios de bedelia: Lunes a Viernes de 20 a 22 hs
    </footer>
</body>

</html>