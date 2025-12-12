<?php
require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/../models/Usuarios.php';



function loginUsuario(string $username, string $password): array {
    $username = trim($username);
    $password = trim($password);

    if (!is_string($username) || !is_string($password) || $username === '' || $password === '') {
        return [
            'success' => false,
            'message' => 'Los campos son obligatorios y deben ser texto',
            'errors' => ['code' => 'empty_fields', 'detail' => 'Los campos son requeridos']
        ];
    }

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || !password_verify($password, $row['password_hash'])) {
            usleep(500000);
            error_log("Intento de login fallido para usuario: $username");
            return [
                'success' => false,
                'message' => 'Nombre de usuario o contraseña incorrectos',
                'errors' => ['code' => 'invalid_credentials', 'detail' => 'Credenciales inválidas']
            ];
        }

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['usuario'];
        error_log("Usuario autenticado exitosamente: $username");

        return [
            'success' => true,
            'message' => 'Usuario autenticado exitosamente',
            'data' => ['id' => $row['id'], 'usuario' => $row['usuario']]
        ];

    } catch (PDOException $e) {
        error_log("Error al validar el usuario $username: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error al validar el usuario',
            'errors' => ['code' => 'database_error', 'detail' => $e->getMessage()]
        ];
    } catch (Exception $e) {
        error_log("Error inesperado: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error interno del servidor',
            'errors' => ['code' => 'internal_server_error', 'detail' => 'Error interno del servidor']
        ];
    }
}

function logoutUsuario(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}
