<?php
// Simulamos una lista de libros (puedes cambiarlo por cualquier cosa)
$books = [
    "Libro 1", "Libro 2", "Libro 3", "Libro 4", "Libro 5",
    "Libro 6", "Libro 7", "Libro 8", "Libro 9", "Libro 10"
];

// Total de libros
$totalBooks = count($books);

// Libros que queremos mostrar por página
$booksPerPage = 3;

// Total de páginas necesarias
$totalPages = ceil($totalBooks / $booksPerPage);

// Número de página actual (obtenido por GET), por defecto es 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculamos el índice de inicio de los libros a mostrar
$startIndex = ($page - 1) * $booksPerPage;

// Extraemos los libros a mostrar en esta página
$booksToShow = array_slice($books, $startIndex, $booksPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paginador PHP</title>
</head>
<body>

    <h2>Libros en esta página</h2>
    <ul>
        <?php foreach ($booksToShow as $book): ?>
            <li><?php echo $book; ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- PAGINACIÓN -->
    <div style="margin-bottom: 100px; margin-top: 50px;">
        <?php if ($page > 1): ?>
            <!-- Botón para ir a la primera página -->
            <a href="?page=1"><<</a>
            <!-- Botón para ir a la página anterior -->
            <a href="?page=<?php echo $page - 1; ?>"><</a>
        <?php endif; ?>

        <!-- Mostramos en qué página estamos y cuántas hay en total -->
        <span>Página <?php echo $page; ?> de <?php echo $totalPages; ?></span>

        <?php if ($page < $totalPages): ?>
            <!-- Botón para ir a la siguiente página -->
            <a href="?page=<?php echo $page + 1; ?>">></a>
            <!-- Botón para ir a la última página -->
            <a href="?page=<?php echo $totalPages; ?>">>></a>
        <?php endif; ?>
    </div>

</body>
</html>
