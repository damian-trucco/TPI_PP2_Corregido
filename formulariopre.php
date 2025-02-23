<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Formulario de Pre-Inscripción</title>
    <style>
    /* Estilos generales */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
    text-align: center;
}

form {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
    text-align: left;
}

h1 {
    text-align: center;
    color: #333;
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.mandatory {
    color: red;
}

/* Estilos para los botones */
.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

button {
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    flex: 1;
    margin: 5px;
}

button[name="enviar"] {
    background-color: #90EE90; /* Verde claro */
    color: black;
}

button[type="reset"] {
    background-color: #FFB6C1; /* Rojo claro */
    color: black;
}

button.print-button {
    background-color: #ADD8E6; /* Azul claro */
    color: black;
}

button:hover {
    opacity: 0.8;
}

    </style>
</head>
<body>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../proyecto_pp2/PHPMailer/src/Exception.php';
require '../proyecto_pp2/PHPMailer/src/PHPMailer.php';
require '../proyecto_pp2/PHPMailer/src/SMTP.php';

session_start(); // Iniciar sesión para manejar mensajes temporales

$mensaje = ""; // Variable para mostrar mensajes al usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    if (
        !empty($_POST['nombre']) && 
        !empty($_POST['apellido']) && 
        !empty($_POST['documento']) &&
        !empty($_POST['domicilio']) &&
        !empty($_POST['email']) &&
        !empty($_POST['carrera']) // Validar que se haya seleccionado una carrera
    ) {
        require 'conexion.php'; // Incluir el archivo de conexión

        // Sanitizar y asignar valores del formulario
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $documento = $conn->real_escape_string($_POST['documento']);
        $domicilio = $conn->real_escape_string($_POST['domicilio']);
        $email = $conn->real_escape_string($_POST['email']);
        $carrera = $conn->real_escape_string($_POST['carrera']);

        // Query SQL para insertar datos
        $sql = "INSERT INTO pre_inscripcion (nombre, apellido, documento, domicilio, email, carrera) 
                VALUES ('$nombre', '$apellido', '$documento', '$domicilio', '$email', '$carrera')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Registro exitoso. Se envió un correo de confirmación a $email.";

            // Enviar correo de confirmación
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'urquizapp2@gmail.com';
                $mail->Password = 'kjsi wlpz keen eqrp';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->CharSet = 'UTF-8';
                $mail->setFrom('urquizapp2@gmail.com', 'Formulario Pre-Inscripción');
                $mail->addAddress($email);
                $mail->Subject = 'Confirmación de Pre-Inscripción';
                $mail->Body = "Hola $nombre,\n\nGracias por completar el formulario de pre-inscripción. Te has inscripto en la carrera: $carrera.\n\nPara completar la inscripción, deberás presentar la siguiente documentación:\n- DNI (original y copia).\n- Partida de nacimiento (copia legalizada).\n- Certificado de título secundario (copia legalizada) o constancia de título en trámite.";

                $mail->send();
            } catch (Exception $e) {
                $_SESSION['mensaje'] = "Registro exitoso, pero hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['mensaje'] = "Error al guardar los datos: " . $conn->error;
        }

        // Cerrar conexión
        $conn->close();

        // Redirigir para evitar reenvío
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Mostrar mensaje desde la sesión, si existe, y luego destruirlo
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Destruir el mensaje después de mostrarlo
}
?>

<?php if (!empty($mensaje)): ?>
    <div class="mensaje <?= strpos($mensaje, 'Error') !== false ? 'error' : 'exito'; ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <h1>Formulario de Pre-Inscripción</h1>

    <label for="nombre">Nombre <span class="mandatory">*</span></label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="apellido">Apellido <span class="mandatory">*</span></label>
    <input type="text" id="apellido" name="apellido" required>

    <label for="documento">Documento <span class="mandatory">*</span></label>
    <input type="text" id="documento" name="documento" required>

    <label for="domicilio">Domicilio <span class="mandatory">*</span></label>
    <input type="text" id="domicilio" name="domicilio" required>

    <label for="email">Email <span class="mandatory">*</span></label>
    <input type="email" id="email" name="email" required>

    <!-- Campo para seleccionar la carrera -->
    <label for="carrera">Carrera a la que se inscribe <span class="mandatory">*</span></label>
    <select id="carrera" name="carrera" required>
        <option value="">Seleccione una carrera...</option>
        <option value="TÉCNICO SUPERIOR EN ANÁLISIS FUNCIONAL DE SISTEMAS INFORMÁTICOS">
            TÉCNICO SUPERIOR EN ANÁLISIS FUNCIONAL DE SISTEMAS INFORMÁTICOS
        </option>
        <option value="TÉCNICO SUPERIOR EN DESARROLLO DE SOFTWARE">
            TÉCNICO SUPERIOR EN DESARROLLO DE SOFTWARE
        </option>
        <option value="TÉCNICO SUPERIOR EN INFRAESTRUCTURA DE TECNOLOGÍA DE LA INFORMACIÓN">
            TÉCNICO SUPERIOR EN INFRAESTRUCTURA DE TECNOLOGÍA DE LA INFORMACIÓN
        </option>
    </select>

    <div class="form-actions">
        <button type="submit" name="enviar">Enviar</button>
        <button type="reset">Borrar todo</button>
        <button type="button" class="print-button" onclick="window.print();">Imprimir formulario</button>
    </div> 
</form>

</body>
</html>
