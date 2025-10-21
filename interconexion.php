<?php
// Incluir archivo de configuración
require_once 'conexion.php';

// Iniciar sesión para mensajes
session_start();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Conectar a la base de datos
    $conexion = conectarDB();
    
    // Obtener y limpiar los datos del formulario
    $nombre = $conexion->real_escape_string(trim($_POST['nombre']));
    $telefono = $conexion->real_escape_string(trim($_POST['telefono']));
    $correo = $conexion->real_escape_string(trim($_POST['correo']));
    $solicitud = $conexion->real_escape_string(trim($_POST['solicitud']));
    
    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($telefono) || empty($correo) || empty($solicitud)) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header("Location: contacto.html");
        exit();
    }
    
    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El formato del correo electrónico no es válido";
        header("Location: contacto.html");
        exit();
    }
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO contactos (nombre, telefono, correo, solicitud, fecha_registro) 
            VALUES (?, ?, ?, ?, NOW())";
    
    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("ssss", $nombre, $telefono, $correo, $solicitud);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $_SESSION['success'] = "¡Solicitud enviada exitosamente!";
            $stmt->close();
            cerrarDB($conexion);
            header("Location: exito.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al guardar la solicitud: " . $stmt->error;
            $stmt->close();
            cerrarDB($conexion);
            header("Location: contacto.html");
            exit();
        }
    } else {
        $_SESSION['error'] = "Error en la preparación de la consulta: " . $conexion->error;
        cerrarDB($conexion);
        header("Location: contacto.html");
        exit();
    }
    
} else {
    // Si alguien intenta acceder directamente a este archivo
    header("Location: contacto.html");
    exit();
}
?>
