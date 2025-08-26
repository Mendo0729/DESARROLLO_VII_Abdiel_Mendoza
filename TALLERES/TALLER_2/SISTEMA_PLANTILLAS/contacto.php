<?php
$paginaActual = 'contacto';
require_once 'plantillas/funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include 'plantillas/encabezado.php';
?>

<h2>Contáctanos</h2>
<p>Puedes enviarnos un correo a contacto@misitio.com o llamarnos al 6000-1234.</p>

<?php
include 'plantillas/pie_pagina.php';
?>
