<?php
// Definición de variables
$nombre_completo = "Abdiel Mendoza";
$edad = 22;
$correo = "abdiel.mendoza@example.com";
$telefono = "6000-1234";

// Definición de constante
define("OCUPACION", "Estudiante");

// --- Concatenación con echo ---
echo "Hola, mi nombre es " . $nombre_completo . ", tengo " . $edad . " años. ";
echo "Puedes contactarme al correo " . $correo . " o al teléfono " . $telefono . ". ";
echo "Actualmente mi ocupación es: " . OCUPACION . ".<br><br>";

// --- Concatenación con print ---
print("Hola, soy " . $nombre_completo . " y estudio actualmente. Mi edad es " . $edad . " años.<br><br>");

// --- Formato con printf ---
printf("Datos de contacto: %s | Correo: %s | Teléfono: %s | Ocupación: %s<br><br>",  $nombre_completo, $correo, $telefono, OCUPACION);

// --- Mostrar tipos y valores ---
echo "<h3>Tipos y valores:</h3>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
?>
