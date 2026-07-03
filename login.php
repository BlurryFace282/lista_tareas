<?php
// Iniciamos la sesión para poder guardar los datos del usuario
session_start();
include 'conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Buscamos al usuario por su correo electrónico
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe, verificamos si la contraseña coincide con el hash encriptado
        if ($usuario && password_verify($password, $usuario['password'])) {
            // ¡Login correcto! Guardamos el ID y el nombre en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];

            // Redireccionamos a la lista de tareas (index.php)
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "<p style='color: red;'>Correo o contraseña incorrectos.</p>";
        }
    } else {
        $mensaje = "<p style='color: red;'>Por favor, llena todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; margin-top: 50px; }
        .contenedor { background: white; max-width: 350px; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 95%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Iniciar Sesión</h2>
    
    <?php echo $mensaje; ?>

    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>

    <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
</div>

</body>
</html>