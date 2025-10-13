<?php
// Crear una cookie que expira en 1 hora
//setcookie("usuario", "Juan", time() + 3600, "/");

//echo "Cookie 'usuario' creada.";

setcookie("usuario", "Juan", [
    'expires' => time() + 3600,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

echo "Cookie segura 'usuario' creada.";
?>
     