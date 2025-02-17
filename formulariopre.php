<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Formulario de Pre-Inscripción</title>
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
    if (!empty($_POST['nombre']) && !empty($_POST['email'])) {
        $nombre = htmlspecialchars($_POST['nombre']);
        $email_destinatario = htmlspecialchars($_POST['email']);
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'urquizapp2@gmail.com'; // Tu correo
            $mail->Password = 'kjsi wlpz keen eqrp'; // Tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Configuración del correo
            $mail->CharSet = 'UTF-8'; // Configura el charset a UTF-8
            $mail->setFrom('urquizapp2@gmail.com', 'Formulario Pre-Inscripción');
            $mail->addAddress($email_destinatario); // Correo ingresado en el formulario
            $mail->Subject = 'Confirmación de Pre-Inscripción';
            $mail->Body = "Hola $nombre,\n\nGracias por completar el formulario de pre-inscripción. Para completar la inscripción debera presertar la siguiente documentación impresa: \n• Documento Nacional de Identidad (DNI original y copia). \n• Partida de Nacimiento (Copia legalizada por tribunales). \n• Certificado de Título Secundario (Copia legalizada por tribunales) o constancia de título en trámite.";

	    require 'conexion.php'; // Incluir el archivo de conexión

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
		if (
		        !empty($_POST['nombre']) && 
		        !empty($_POST['apellido']) && 
		        !empty($_POST['documento']) &&
		        !empty($_POST['domicilio']) &&
		        !empty($_POST['email'])

    		) {
        	// Sanitizar y asignar valores del formulario
      			$nombre = $conn->real_escape_string($_POST['nombre']);
        		$apellido = $conn->real_escape_string($_POST['apellido']);
        		$documento = $conn->real_escape_string($_POST['documento']);
		        $domicilio = $conn->real_escape_string($_POST['domicilio']);
		        $email = $conn->real_escape_string($_POST['email']);

        // Query SQL para insertar datos
        $sql = "INSERT INTO pre_inscripcion (nombre, apellido, documento, domicilio, email) 
                VALUES ('$nombre', '$apellido', '$documento', '$domicilio', '$email')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Registro exitoso. Se envió un correo de confirmación a $email.";
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

            // Enviar correo
            $mail->send();

            // Guardar mensaje de éxito en la sesión
            $_SESSION['mensaje'] = "Se envió un correo de confirmación a $email_destinatario. Por favor revisa tu correo eléctronico.";
        } catch (Exception $e) {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje'] = "Error al enviar el correo: {$mail->ErrorInfo}";
        }

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
        <input type="int" id="documento" name="documento" required>

        <label for="domicilio">Domicilio <span class="mandatory">*</span></label>
        <input type="text" id="domicilio" name="domicilio" required>

        <label for="email">Email <span class="mandatory">*</span></label>
        <input type="email" id="email" name="email" required>


        <div class="form-actions">
            <button type="submit" name="enviar">Enviar</button>
            <button type="reset">Borrar todo</button>
            <button type="button" class="print-button" onclick="window.print();">Imprimir formulario</button>
        </div> 
    </form>

</body>
</html>
