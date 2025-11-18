<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Estudiante') {
    header('Location: login.php');
    exit;
}

require 'calificaciones.php';


$usuario_actual = $_SESSION['usuario'];
$datos_estudiante = $calificaciones[$usuario_actual] ?? [
    'nombre' => 'Estudiante',
    'materias' => []
];

$total_creditos = 0;

foreach ($datos_estudiante['materias'] as $materia) {
    $total_creditos += $materia['creditos'];
}

$mejor_materia = "";
$mejor_nota = 0;
$peor_materia = "";
$peor_nota = 100;

foreach ($datos_estudiante['materias'] as $materia) {
    if ($materia['calificacion'] > $mejor_nota) {
        $mejor_nota = $materia['calificacion'];
        $mejor_materia = $materia['nombre'];
    }
    if ($materia['calificacion'] < $peor_nota) {
        $peor_nota = $materia['calificacion'];
        $peor_materia = $materia['nombre'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante</title>
</head>
<body>

    <h1>Dashboard del Estudiante</h1>

    <p>Estudiante: <?php echo htmlspecialchars($datos_estudiante['nombre']); ?></p>
    <a href="logout.php">Cerrar Sesión</a>

    <h2>Resumen</h2>
    
    <p><strong>Mejor Materia:</strong> 
        <?php echo htmlspecialchars($mejor_materia); ?> (<?php echo $mejor_nota; ?>)
    </p>

    <p><strong>Peor Materia:</strong> 
        <?php echo htmlspecialchars($peor_materia); ?> (<?php echo $peor_nota; ?>)
    </p>

    <p><strong>Total de Materias:</strong> <?php echo count($datos_estudiante['materias']); ?></p>
    <p><strong>Créditos Totales:</strong> <?php echo $total_creditos; ?></p>

    <h2>Mis Calificaciones</h2>

    <?php if (empty($datos_estudiante['materias'])): ?>

        <p>No hay calificaciones disponibles.</p>

    <?php else: ?>

        <?php foreach ($datos_estudiante['materias'] as $materia): ?>
            <div>
                <p><strong><?php echo htmlspecialchars($materia['nombre']); ?></strong></p>
                <p>Calificación: <?php echo $materia['calificacion']; ?></p>
                <p>Créditos: <?php echo $materia['creditos']; ?></p>
                <hr>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</body>
</html>
