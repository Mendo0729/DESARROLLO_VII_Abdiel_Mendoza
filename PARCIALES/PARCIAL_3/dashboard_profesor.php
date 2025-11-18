<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Profesor') {
    header('Location: login.php');
    exit;
}

require 'calificaciones.php';

$calificaciones_profesor = [];

foreach ($calificaciones as $usuario => $data) {
    $fila = [
        'estudiante' => $usuario,
        'nombre'     => $data['nombre'],
        'matematicas' => $data['materias'][0]['calificacion'],
        'ciencias'    => $data['materias'][1]['calificacion'],
        'historia'    => $data['materias'][2]['calificacion'],
        'ingles'      => $data['materias'][3]['calificacion'],
    ];

    $calificaciones_profesor[] = $fila;
}

$total_estudiantes = count($calificaciones_profesor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profesor</title>
</head>
<body>

    <h1>Dashboard del Profesor</h1>

    <div>
        <span>Profesor: <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <h2>Resumen General</h2>

    <div>
        <p><strong>Total de Estudiantes:</strong> <?php echo $total_estudiantes; ?></p>
        <p><strong>Materias Registradas:</strong> 4</p>
    </div>

    <h2>Calificaciones de Estudiantes</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Matemáticas</th>
                <th>Ciencias</th>
                <th>Historia</th>
                <th>Inglés</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calificaciones_profesor as $cal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cal['estudiante']); ?></td>
                    <td><?php echo htmlspecialchars($cal['nombre']); ?></td>
                    <td><?php echo $cal['matematicas']; ?></td>
                    <td><?php echo $cal['ciencias']; ?></td>
                    <td><?php echo $cal['historia']; ?></td>
                    <td><?php echo $cal['ingles']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
