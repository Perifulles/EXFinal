<?php
// Código Vicent

// Llamamos al método "extraer" del objeto $Miguel para obtener todos los libros
$books = $Miguel->extraer();

// Contamos cuántos libros hay en total
$totalBooks = count($books);

// Definimos cuántos libros se mostrarán por página
$booksPerPage = 3;

// Calculamos el número total de páginas (redondeando hacia arriba)
$totalPages = ceil($totalBooks / $booksPerPage);

// Obtenemos el número de página actual desde la URL (por GET). Si no existe, usamos la página 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculamos desde qué índice empezamos a mostrar libros en esta página
$startIndex = ($page - 1) * $booksPerPage;

// Cortamos el array original para mostrar solo los libros correspondientes a esta página
$booksToShow = array_slice($books, $startIndex, $booksPerPage);

?>
