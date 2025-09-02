
<?php
// Ejemplo básico de strpos()
$texto = "Programar en PHP es muy divertido y poderoso.";
$posicion = strpos($texto, "PHP");
echo "La palabra 'PHP' comienza en la posición: $posicion</br>";

$busqueda = strpos($texto, "Java");
echo ($busqueda === false ? "No se encontró 'Java'." : "Se encontró 'Java'.") . "</br>";

// Ejercicio: Verificar si un email es válido (contiene @)
function esEmailValido($email) {
    return strpos($email, "@") !== false;
}

$email1 = "usuario@example.com";
$email2 = "usuarioe@1xample.com";
echo "</br>¿'$email1' es un email válido? " . (esEmailValido($email1) ? "Sí" : "No") . "</br>";
echo "¿'$email2' es un email válido? " . (esEmailValido($email2) ? "Sí" : "No") . "</br>";

// Bonus: Encontrar todas las ocurrencias de una letra
function encontrarTodasLasOcurrencias($texto, $letra) {
    $posiciones = [];
    $posicion = 0;
    while (($posicion = strpos($texto, $letra, $posicion)) !== false) {
        $posiciones[] = $posicion;
        $posicion++;
    }
    return $posiciones;
}

$frase = "La programación es divertida y desafiante";
$letra = "a";
$ocurrencias = encontrarTodasLasOcurrencias($frase, $letra);
echo "</br>Posiciones de la letra '$letra' en '$frase': " . implode(", ", $ocurrencias) . "</br>";

// Extra: Extraer el nombre de usuario de una dirección de correo electrónico
function extraerNombreUsuario($email) {
    $posicionArroba = strpos($email, "@");
    if ($posicionArroba === false) {
        return false;
    }
    return substr($email, 0, $posicionArroba);
}

$email = "usuario@example.com";
$nombreUsuario = extraerNombreUsuario($email);
echo "</br>Nombre de usuario extraído de '$email': " . ($nombreUsuario !== false ? $nombreUsuario : "Email no válido") . "</br>";

// Desafío: Censurar palabras en un texto
function censurarPalabras($texto, $palabrasCensuradas) {
    foreach ($palabrasCensuradas as $palabra) {
        $longitud = strlen($palabra);
        $censura = str_repeat("*", $longitud);
        $posicion = 0;
        while (($posicion = stripos($texto, $palabra, $posicion)) !== false) {
            $texto = substr_replace($texto, $censura, $posicion, $longitud);
            $posicion += $longitud;
        }
    }
    return $texto;
}

echo censurarPalabras("El TEXTO debe ser Censurado.", ["texto", "censurado"]);

$textoOriginal = "Este es un texto con algunas palabras que deben ser censuradas.";
$palabrasCensuradas = ["texto", "palabras", "censuradas"];
$textoCensurado = censurarPalabras($textoOriginal, $palabrasCensuradas);
echo "</br>Texto original: $textoOriginal</br>";
echo "Texto censurado: $textoCensurado</br>";

// Ejemplo adicional: Verificar si una URL es segura (comienza con https)
function esUrlSegura($url) {
    return strpos($url, "https://") === 0;
}

$url1 = "https://www.example.com";
$url2 = "http://www.example.com";
echo "</br>¿'$url1' es una URL segura? " . (esUrlSegura($url1) ? "Sí" : "No") . "</br>";
echo "¿'$url2' es una URL segura? " . (esUrlSegura($url2) ? "Sí" : "No") . "</br>";

function obtenerDominio($url) {
    $inicio = strpos($url, "://");
    if ($inicio === false) return false;
    $inicio += 3;
    $fin = strpos($url, "/", $inicio);
    if ($fin === false) {
        return substr($url, $inicio);
    }
    return substr($url, $inicio, $fin - $inicio);
}

echo obtenerDominio("https://www.ejemplo.com/pagina") . "</br>"; 
echo obtenerDominio("http://openai.com") . "</br>";
?>