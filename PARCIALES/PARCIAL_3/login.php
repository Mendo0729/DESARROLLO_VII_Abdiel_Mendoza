<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: ' . ($_SESSION['rol'] === 'Profesor' ? 'dashboard_profesor.php' : 'dashboard_estudiante.php'));
    exit;
}

$usuarios = [
    ['usuario' => 'profesor1', 'password' => 'pass12345', 'rol' => 'Profesor'],
    ['usuario' => 'abdiel2907', 'password' => '12345', 'rol' => 'Estudiante'],
    ['usuario' => 'ana123', 'password' => 'aaa123', 'rol' => 'Estudiante'],
    ['usuario' => 'juan456', 'password' => 'abc456', 'rol' => 'Estudiante'],
    ['usuario' => 'sofia789', 'password' => '123456', 'rol' => 'Estudiante'],
    ['usuario' => 'luis999', 'password' => '987654', 'rol' => 'Estudiante']
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($usuario) || empty($password)) {
        $error = 'Por favor complete todos los campos';
    } elseif (strlen($usuario) < 3) {
        $error = 'El nombre de usuario debe tener al menos 3 caracteres';
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $usuario)) {
        $error = 'El usuario solo puede contener letras y números';
    } elseif (strlen($password) < 5) {
        $error = 'La contraseña debe tener al menos 5 caracteres';
    } else {
        $usuario_encontrado = false;
        foreach ($usuarios as $u) {
            if ($u['usuario'] === $usuario && $u['password'] === $password) {
                $_SESSION['usuario'] = $u['usuario'];
                $_SESSION['rol'] = $u['rol'];
                $usuario_encontrado = true;
                if ($u['rol'] === 'Profesor') {
                    header('Location: dashboard_profesor.php');
                } else {
                    header('Location: dashboard_estudiante.php');
                }
                exit;
            }
        }
        
        if (!$usuario_encontrado) {
            $error = 'Usuario o contraseña incorrectos';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Sistema de Calificaciones</title>
</head>
<body>

    <h1>Iniciar Sesión</h1>
    <p>Sistema de Gestión de Calificaciones</p>
        
    <?php if ($error): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
        
    <form method="POST" action="">
        <div>
            <label for="usuario">Nombre de Usuario</label>
            <input 
                type="text" 
                id="usuario" 
                name="usuario"
                placeholder="Ingrese su usuario"
                value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>"
                required
            >
        </div>
            
        <div>
            <label for="password">Contraseña</label>
            <input 
                type="password" 
                id="password" 
                name="password"
                placeholder="Ingrese su contraseña"
                required
            >
        </div>
            
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
