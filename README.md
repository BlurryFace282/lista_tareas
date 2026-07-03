# Lista de Tareas Full-Stack con Sistema de Usuarios

¡Bienvenido! Este es un proyecto de práctica desarrollado para gestionar tareas pendientes de forma segura e independiente por usuario.

## Características del proyecto
* **Autenticación Completa** Sistema de Registro, Inicio de Sesión (Login) y Cierre de Sesión (Logout).
* **Seguridad Avanzada:** Las contraseñas de los usuarios se almacenan encriptadas en la base de datos utilizando el algoritmo `password_hash()` de PHP.
* **Sesiones Activas:** Uso de `session_start()` para proteger rutas; si un usuario no está logueado, no puede acceder a la lista de tareas.
* **Base de Datos Relacional:** Conexión segura mediante PDO a MySQL, enlazando cada tarea con su respectivo usuario mediante llaves foráneas (`FOREIGN KEY`) y borrado en cascada.

## Tecnologías utilizadas
* **Backend:** PHP (Programación procedimental orientada a la seguridad)
* **Frontend:** HTML5, CSS3 básicos
* **Base de Datos:** MySQL / MariaDB (Gestionado con HeidiSQL)
* **Entorno de Desarrollo:** Laragon

---
*Proyecto desarrollado por Carlos Landeros como parte de mi ruta de aprendizaje hacia el desarrollo Backend profesional.*
