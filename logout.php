<?php
// Cerramos la sesión activa y devolvemos al usuario a la pantalla de ingreso.
session_start();
session_destroy();
header("Location: login.php");
exit();
?>