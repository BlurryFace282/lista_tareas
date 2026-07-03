<?php
// 1. INICIAR SESIÓN Y PROTEGER LA PÁGINA
session_start();

// Si no existe la sesión del usuario, lo mandamos directo al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

// Guardamos el ID del usuario logueado en una variable más cómoda
$id_usuario_actual = $_SESSION['usuario_id'];


// 2. LÓGICA PARA INSERTAR UNA NUEVA TAREA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tarea'])) {
    $nueva_tarea = $_POST['tarea'];
    
    // Ahora incluimos el usuario_id en la inserción
    $sql = "INSERT INTO tareas (nombre, usuario_id) VALUES (:nombre, :usuario_id)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'nombre' => $nueva_tarea,
        'usuario_id' => $id_usuario_actual
    ]);
    
    header("Location: index.php");
    exit();
}


// 3. LÓGICA PARA LEER LAS TAREAS (Solo las del usuario logueado)
$sql_consulta = "SELECT * FROM tareas WHERE usuario_id = :usuario_id ORDER BY id DESC";
$stmt_consulta = $conexion->prepare($sql_consulta);
$stmt_consulta->execute(['usuario_id' => $id_usuario_actual]);
$tareas = $stmt_consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Lista de Tareas Segura</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; margin-top: 50px; }
        .contenedor { background: white; max-width: 400px; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .barra-usuario { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .btn-salir { color: red; text-decoration: none; font-size: 14px; }
        input[type="text"] { width: 65%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        ul { list-style: none; padding: 0; text-align: left; }
        li { padding: 10px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

<div class="contenedor">
    <div class="barra-usuario">
        <span>Hola, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> 👋</span>
        <a href="logout.php" class="btn-salir">Cerrar sesión</a>
    </div>

    <h2>Mis Tareas</h2>
    
    <form action="index.php" method="POST">
        <input type="text" name="tarea" placeholder="Nueva tarea..." required>
        <button type="submit">Agregar</button>
    </form>

    <ul>
        <?php if (count($tareas) > 0): ?>
            <?php foreach ($tareas as $t): ?>
                <li><?php echo htmlspecialchars($t['nombre']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #888;">No tienes tareas pendientes. ¡Buen trabajo!</p>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>