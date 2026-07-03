<?php
// Datos de conexión en tu computadora (Local)
$host = "localhost";
$user = "root";
$password = "";
$dbname = "todo_db";

/* $host = "sql103.infinityfree.com"; //esto me lo dio infinity free al crear la bd
$user = "if0_42308846"; //este tambien lo da infinity - usuario de mysql
$password = "Carloslaes2807";  //contraseña bd que cambie
$dbname = "if0_42308846_todo_db"; //nombre de la base de datos */

// Crear la conexión usando PDO (es más seguro y moderno)
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Configurar para que muestre errores si algo sale mal
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>