<?php

require_once 'conexion.php';


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $conexion = conectarDB();
    
    $nombre = $conexion->real_escape_string(trim($_POST['nombre']));
    $telefono = $conexion->real_escape_string(trim($_POST['telefono']));
    $correo = $conexion->real_escape_string(trim($_POST['correo']));
    $solicitud = $conexion->real_escape_string(trim($_POST['solicitud']));
    
    if (empty($nombre) || empty($telefono) || empty($correo) || empty($solicitud)) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header("Location: ../contacto.html");
        exit();
    }
    
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El formato del correo electrónico no es válido";
        header("Location: ../contacto.html");
        exit();
    }
    
    $sql = "INSERT INTO contactos (nombre, telefono, correo, solicitud, fecha_registro) 
            VALUES (?, ?, ?, ?, NOW())";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $nombre, $telefono, $correo, $solicitud);
        
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
            header("Location: ../contacto.html");
            exit();
        }
    } else {
        $_SESSION['error'] = "Error en la preparación de la consulta: " . $conexion->error;
        cerrarDB($conexion);
        header("Location: ../contacto.html");
        exit();
    }
    
} else {
    header("Location: ../contacto.html");
    exit();
}
?>
