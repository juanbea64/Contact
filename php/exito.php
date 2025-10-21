<?php
session_start();
$mensaje = isset($_SESSION['success']) ? $_SESSION['success'] : 'Operación completada';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Enviada</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="welcome-box">
            <div class="success-message">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
            <h1>✓ ¡Gracias!</h1>
            <p>Tu solicitud ha sido enviada correctamente. Nos pondremos en contacto contigo pronto.</p>
            <a href="../index.html" class="btn-primary">Volver al Inicio</a>
            <a href="../contacto.html" class="btn-back">Nuevo Contacto</a>
        </div>
    </div>
</body>
</html>
