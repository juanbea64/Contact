<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; 
$DB_NAME = 'contactos_db';

// Crear conexión
function conectarDB() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
    $conexion = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    $conexion->set_charset("utf8");
    
    return $conexion;
}

// Cerrar conexión
function cerrarDB($conexion) {
    $conexion->close();
}
?>
