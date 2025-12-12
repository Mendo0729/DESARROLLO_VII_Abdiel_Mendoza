<?php
require_once __DIR__ . '/../../database/database.php'; // Ajusta la ruta a tu conexión PDO

try {
    $pdo = getPDO();

    $usuario = 'abdiel';
    $password = '123456';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $existe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existe) {
        // Actualizar la contraseña
        $stmt = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE usuario = ?");
        $stmt->execute([$password_hash, $usuario]);
        echo "Usuario '$usuario' ya existía. Contraseña actualizada correctamente.";
    } else {
        // Crear usuario
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password_hash) VALUES (?, ?)");
        $stmt->execute([$usuario, $password_hash]);
        echo "Usuario '$usuario' creado correctamente con la contraseña '$password'.";
    }
} catch (PDOException $e) {
    echo "Error de conexión o al crear el usuario: " . $e->getMessage();
}
