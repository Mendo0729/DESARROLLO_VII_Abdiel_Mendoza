<?php

require_once 'operaciones_cadenas.php';

$frases = [
    "La programación es el lenguaje del futuro.",
    "Aprender a pensar es más importante que aprender a memorizar.",
    "Con práctica y paciencia, todo conocimiento se vuelve más fácil.",
    "El mundo en el que vivimos, no es el mismo que el de ayer."
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de frases</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2>Resultados de procesar las frases</h2>
    <table>
        <tr>
            <th>Frase</th>
            <th>Palabras Repetidas</th>
            <th>Capitalizar Palabras</th>
        </tr>
        <?php foreach($frases as $frase): ?>
            <tr>
                <td><?= ($frase) ?></td>
                <td><?= contar_palabras_repetidas($frase) ?></td>
                <td><?= capitalizar_palabras($frase) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>