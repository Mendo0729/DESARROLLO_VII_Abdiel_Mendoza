
<?php
// Ejemplo básico de in_array()
$frutas = ["manzana", "banana", "naranja", "uva"];
$buscar = "banana";

if (in_array($buscar, $frutas)) {
    echo "$buscar está en la lista de frutas.</br>";
} else {
    echo "$buscar no está en la lista de frutas.</br>";
}

// Ejemplo con comparación estricta
$numeros = [1, "2", 3, "4", 5];
$buscarNumero = "2";

echo "</br>Buscando '$buscarNumero' en el array de números:</br>";
echo "Comparación normal: " . (in_array($buscarNumero, $numeros) ? "Encontrado" : "No encontrado") . "</br>";
echo "Comparación estricta: " . (in_array($buscarNumero, $numeros, true) ? "Encontrado" : "No encontrado") . "</br>";

// Ejercicio: Verifica si un color está en la lista de colores primarios
$coloresPrimarios = ["Verde", "azul", "Cial"];
$colorUsuario = "Gris"; // Cambia este color para probar diferentes resultados

echo "</br>¿$colorUsuario es un color primario? " . 
     (in_array(strtolower($colorUsuario), $coloresPrimarios) ? "Sí" : "No") . "</br>";

// Bonus: Función para verificar múltiples elementos
function elementosEnArray($elementos, $array) {
    $resultados = [];
    foreach ($elementos as $elemento) {
        $resultados[$elemento] = in_array($elemento, $array);
    }
    return $resultados;
}

$diasSemana = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
$diasBuscar = ["lunes", "sábado", "festivo","viernes"];

$resultadosDias = elementosEnArray($diasBuscar, $diasSemana);
echo "</br>Resultados de búsqueda de días:</br>";
foreach ($resultadosDias as $dia => $encontrado) {
    echo "$dia: " . ($encontrado ? "Encontrado" : "No encontrado") . "</br>";
}

// Extra: Uso de in_array() con arrays multidimensionales
$personas = [
    ["nombre" => "Abdiel", "edad" => 23],
    ["nombre" => "María", "edad" => 30],
    ["nombre" => "Carlos", "edad" => 22]
];

$buscarPersona = ["nombre" => "Jose", "edad" => 30];

echo "</br>Buscando persona en el array:</br>";
echo in_array($buscarPersona, $personas) ? "Persona encontrada" : "Persona no encontrada";

// Desafío: Crear una función de búsqueda case-insensitive
function in_array_case_insensitive($needle, $haystack) {
    return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

$lenguajes = ["PHP", "Python", "JavaScript","C#"];
$buscarLenguaje = "C++";

echo "</br></br>Buscando '$buscarLenguaje' en lenguajes de programación:</br>";
echo in_array_case_insensitive($buscarLenguaje, $lenguajes) ? "Encontrado" : "No encontrado";
?>