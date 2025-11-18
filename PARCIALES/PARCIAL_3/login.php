<?php
include 'crear_sesion.php';
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
        
    <form method="POST" action="crear_sesion.php">
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
