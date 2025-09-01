
<?php
// Ejemplo de uso de count()
$frutas = ["Manzana", "Naranja", "Plátano", "Uva", "Pera"];
$numFrutas = count($frutas);

echo "Array de frutas:</br>";
print_r($frutas);
echo "Número de frutas: $numFrutas</br>";

// Ejercicio: Crea un array con los nombres de tus 5 canciones favoritas
// y usa count() para mostrar cuántas canciones hay en tu lista
$misCanciones = ['Last Last', 'Circle', 'Idiota', '25', 'Hollywods Bleading']; // Reemplaza esto con tu array de canciones
$numCanciones = count($misCanciones);

echo "</br>Número de canciones en mi lista: $numCanciones</br>";

// Bonus: Usa count() con un array multidimensional
$playlist = [
    "trap" => ["Esclava", "BOP"],
    "Regueton" => ["Dile", "Limbo", "Señor de la noche"],
    "R&B" => ["Broken Clocks", "Deep"],
    "Pop" => ["Die whit a smile", "Circle"]
];

$totalCanciones = 0;
foreach ($playlist as $genero => $canciones) {
    $numCancionesGenero = count($canciones);
    $totalCanciones += $numCancionesGenero;
    echo "Canciones de $genero: $numCancionesGenero</br>";
}

echo "Total de canciones en la playlist: $totalCanciones</br>";
?>