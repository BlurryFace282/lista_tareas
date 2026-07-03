<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Encriptar la contraseña de forma segura (Algoritmo por defecto: BCRYPT)
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Preparamos la consulta para insertar al nuevo usuario
            $sql = "INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $password_encriptada
            ]);

            $mensaje = "<p style='color: green;'>¡Usuario registrado con éxito! Ya puedes iniciar sesión.</p>";
        } catch (PDOException $e) {
            // Si el usuario o email ya existen, saltará un error por la regla UNIQUE de la base de datos
            $mensaje = "<p style='color: red;'>Error: El usuario o el correo ya están registrados.</p>";
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
    <title>Registro de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; margin-top: 50px; }
        .contenedor { background: white; max-width: 350px; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 95%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Crear Cuenta</h2>
    
    <?php echo $mensaje; ?>

    <form action="registro.php" method="POST">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>

    <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
</div>

</body>
</html>