<?php
session_start();
session_destroy(); // Destruye toda la información de la sesión actual
header("Location: login.php"); // Lo manda de vuelta al Login
exit();
?>