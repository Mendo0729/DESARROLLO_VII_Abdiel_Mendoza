<?php
// Archivo: TALLER_2/generador_patrones.php

echo "<h2>1. Patrón de triángulo rectángulo con for</h2>";

$filas = 5;
for ($i = 1; $i <= $filas; $i++) {
    // imprimir asteriscos según el número de la fila
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}

echo "<h2>2. Números impares del 1 al 20 con while</h2>";

$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) { // condición para solo impares
        echo $numero . " ";
    }
    $numero++;
}

echo "<br><h2>3. Contador regresivo desde 10 hasta 1 con do-while (saltando el 5)</h2>";

$contador = 10;
do {
    if ($contador == 5) {
        $contador--; // reducir el contador antes de continuar para no entrar en bucle
        continue;    // saltar el 5
    }
    echo $contador . " ";
    $contador--;
} while ($contador >= 1);

?>
