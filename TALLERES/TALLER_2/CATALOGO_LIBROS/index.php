<?php
// Incluir los archivos necesarios
include 'includes/funciones.php';
include 'includes/header.php';
?>

<div class="titulo-pagina">
    <h2>Nuestro Catálogo de Libros</h2>
    <p>Descubre nuestra selección de libros clásicos y contemporáneos</p>
</div>

<div class="libros-container">
    <?php
    // Obtener la lista de libros
    $libros = obtenerLibros();
    
    // Mostrar cada libro utilizando un bucle
    foreach ($libros as $libro) {
        echo mostrarDetallesLibro($libro);
    }
    ?>
</div>

<?php
// Incluir el pie de página
include 'includes/footer.php';
?>