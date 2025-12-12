<?php
session_start();

$usuario = $_SESSION['username'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi ERP - Dashboard</title>
</head>
<body>
    <h1>Bienvenido a Mi ERP</h1>

    <?php if ($usuario): ?>
        <p>Hola, <strong><?= htmlspecialchars($usuario) ?></strong></p>
        <p><a href="usuarios/logout.php">Cerrar sesión</a></p>
    <?php else: ?>
        <p>No has iniciado sesión.</p>
        <p><a href="test_login.php">Ir al login</a></p>
    <?php endif; ?>
</body>
</html>
