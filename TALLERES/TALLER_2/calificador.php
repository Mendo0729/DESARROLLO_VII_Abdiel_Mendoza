<?php
// Archivo: TALLER_2/calificador.php

// 1. Declarar una calificación (puedes cambiar el valor para probar)
$calificacion = 82;

// 2. Determinar la letra con if - elseif - else
if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = "A";
} elseif ($calificacion >= 80 && $calificacion <= 89) {
    $letra = "B";
} elseif ($calificacion >= 70 && $calificacion <= 79) {
    $letra = "C";
} elseif ($calificacion >= 60 && $calificacion <= 69) {
    $letra = "D";
} elseif ($calificacion >= 0 && $calificacion <= 59) {
    $letra = "F";
} else {
    $letra = "Valor inválido";
}

// 3. Imprimir mensaje principal
echo "Tu calificación es: " . $letra . "<br>";

// 4. Operador ternario para aprobado o reprobado
echo ($letra != "F") ? "Aprobado<br>" : "Reprobado<br>";

// 5. Switch para mensajes adicionales
switch ($letra) {
    case "A":
        echo "Excelente trabajo";
        break;
    case "B":
        echo "Buen trabajo";
        break;
    case "C":
        echo "Trabajo aceptable";
        break;
    case "D":
        echo "Necesitas mejorar";
        break;
    case "F":
        echo "Debes esforzarte más";
        break;
    default:
        echo "Calificación inválida";
        break;
}
?>
