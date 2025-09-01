
<?php
// Ejemplo de uso de implode()
$frutas = ["Manzana", "Naranja", "Plátano", "Uva"];
$frase = implode(", ", $frutas);

echo "Array de frutas:</br>";
print_r($frutas);
echo "Frase creada: $frase</br>";

// Ejercicio: Crea un array con los nombres de 5 países que te gustaría visitar
// y usa implode() para convertirlo en una cadena separada por guiones (-)
$paises = [
    "Argentina",
    "Brasil",
    "Chile",
    "Colombia",
    "México",
    "Japón"
]; // Reemplaza esto con tu array de países
$listaPaises = implode(" ,", $paises);

echo "</br>Mi lista de países para visitar: $listaPaises</br>";

$frutas = [
    "Manzana",
    "Banana",
    "Naranja",
    "Pera",
    "Mango",
    "Fresa",
    "Uva",
    "Sandía",
    "Kiwi",
    "Piña"
];

$listaFrutas = implode(' - ', $frutas);
echo "</br>Mi lista de frutas favotitas: $listaFrutas</br>";

// Bonus: Usa implode() con un array asociativo
$persona = [
    "nombre" => "Abdiel",
    "edad" => 23,
    "ciudad" => "Colon",
    "altura" => "1.77"
];
$infoPersona = implode(" | ", $persona);

echo "</br>Información de la persona: $infoPersona</br>";
?>