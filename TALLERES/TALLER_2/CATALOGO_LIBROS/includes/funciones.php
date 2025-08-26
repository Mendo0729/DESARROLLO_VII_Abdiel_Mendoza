<?php
/**
 * Funciones para el catálogo de libros
 */

// Función para obtener el array de libros
function obtenerLibros() {
    return array(
        array(
            'id' => 1,
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'genero' => 'Realismo mágico',
            'anio' => 1967,
            'descripcion' => 'Una novela que narra la historia de la familia Buendía a lo largo de siete generaciones en el pueblo ficticio de Macondo.',
            'precio' => 19.99,
            'portada' => 'cien_anos.jpg'
        ),
        array(
            'id' => 2,
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'genero' => 'Ciencia ficción distópica',
            'anio' => 1949,
            'descripcion' => 'Una visión profética de un futuro totalitario donde el gobierno controla cada aspecto de la vida de las personas.',
            'precio' => 15.50,
            'portada' => '1984.jpg'
        ),
        array(
            'id' => 3,
            'titulo' => 'Don Quijote de la Mancha',
            'autor' => 'Miguel de Cervantes',
            'genero' => 'Novela clásica',
            'anio' => 1605,
            'descripcion' => 'La historia de un hidalgo que enloquece después de leer demasiados libros de caballerías y decide convertirse en caballero andante.',
            'precio' => 24.95,
            'portada' => 'quijote.jpg'
        ),
        array(
            'id' => 4,
            'titulo' => 'Orgullo y prejuicio',
            'autor' => 'Jane Austen',
            'genero' => 'Novela romántica',
            'anio' => 1813,
            'descripcion' => 'La historia de Elizabeth Bennet y Fitzwilliam Darcy, y cómo superan sus diferencias y prejuicios para encontrar el amor.',
            'precio' => 17.75,
            'portada' => 'orgullo.jpg'
        ),
        array(
            'id' => 5,
            'titulo' => 'El principito',
            'autor' => 'Antoine de Saint-Exupéry',
            'genero' => 'Fábula',
            'anio' => 1943,
            'descripcion' => 'Un piloto varado en el desierto del Sahara conoce a un pequeño príncipe de otro planeta, quien le cuenta sus experiencias.',
            'precio' => 12.99,
            'portada' => 'principito.jpg'
        )
    );
}

// Función para mostrar los detalles de un libro
function mostrarDetallesLibro($libro) {
    $html = '<div class="libro">';
    $html .= '<h2>' . htmlspecialchars($libro['titulo']) . '</h2>';
    $html .= '<p><strong>Autor:</strong> ' . htmlspecialchars($libro['autor']) . '</p>';
    $html .= '<p><strong>Género:</strong> ' . htmlspecialchars($libro['genero']) . '</p>';
    $html .= '<p><strong>Año de publicación:</strong> ' . htmlspecialchars($libro['anio']) . '</p>';
    $html .= '<p><strong>Precio:</strong> $' . number_format($libro['precio'], 2) . '</p>';
    $html .= '<p><strong>Descripción:</strong> ' . htmlspecialchars($libro['descripcion']) . '</p>';
    $html .= '</div>';
    
    return $html;
}
?>