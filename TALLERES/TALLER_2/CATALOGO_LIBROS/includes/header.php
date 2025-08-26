<?php
// Iniciar la sesión para evitar warnings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Libros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>📚 Catálogo de Libros</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="#">Todos los Libros</a></li>
                    <li><a href="#">Géneros</a></li>
                    <li><a href="#">Autores</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">