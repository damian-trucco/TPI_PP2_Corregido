<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root"; // Cambiar si es necesario
$password = ""; // Cambiar si es necesario
$dbname = "db_urquiza"; // Cambiar si es necesario

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Procesar el formulario al enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    // Consulta preparada para prevenir inyección SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE dni = ? AND password = ?");
    $stmt->bind_param("ss", $dni, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario autenticado con éxito
        echo "<script>alert('Inicio de sesión exitoso');</script>";
        // Redirigir a una página específica si es necesario
    } else {
        // Credenciales incorrectas
        echo "<script>alert('D.N.I. o contraseña incorrectos');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 20px;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .login-container button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form action="login.php" method="post">
            <input type="text" name="dni" placeholder="Ingrese su D.N.I." required>
            <input type="password" name="password" placeholder="Ingrese su contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <a href="alumnosprimero.php">Caso Alumnos Primero</a>
        <a href="alumnossegundoytercero.php">Caso Alumnos Segundo y Tercero</a>
    </div>
</body>
</html>
