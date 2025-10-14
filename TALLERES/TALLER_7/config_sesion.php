<?php
/*
// Configurar opciones de sesión antes de iniciar la sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

session_start();

// Regenerar el ID de sesión periódicamente
if (!isset($_SESSION['ultima_actividad']) || (time() - $_SESSION['ultima_actividad'] > 300)) {
    session_regenerate_id(true);
    $_SESSION['ultima_actividad'] = time();
    //
}
*/
// Configurar las cookies de sesión (sin HTTPS)
session_set_cookie_params([
'lifetime' => 0,
'path' => '/',
'secure' => false,
'httponly' => true,
'samesite' => 'Lax'
]);

session_start();


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = time() . rand(1000, 9999);
}


function csrf_field() {
return '<input type="hidden" name="csrf_token" value="'.htmlspecialchars($_SESSION['csrf_token']).'">';
}


function check_csrf() {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token']) {
        die('CSRF token inválido.');
    }
}


function get_productos_catalogo() {
    return [
        101 => ['nombre' => 'Camiseta Azul', 'precio' => 15.50],
        102 => ['nombre' => 'Gorra Clásica', 'precio' => 9.99],
        103 => ['nombre' => 'Mochila Urbana', 'precio' => 39.90],
        104 => ['nombre' => 'Auriculares', 'precio' => 24.75],
        105 => ['nombre' => 'Taza Café 300ml', 'precio' => 6.00]
    ];
}

function producto_valido($id) {
    $catalogo = get_productos_catalogo();
    return isset($catalogo[$id]);
}

function validar_entero($valor) {
    return (int) $valor;
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
?>