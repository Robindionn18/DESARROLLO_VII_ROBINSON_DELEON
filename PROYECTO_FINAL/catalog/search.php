<?php

require_once '../views/menu.php';
require_once '../ProjectManager.php';
$pm = new ProjectManager();

$books = [];

if (!empty($_GET['keyword'])) {
    $books = $pm->searchBooks($_GET['keyword']);
}
?>

<h2>Buscar Libro</h2>

<form method="get">
    <input type="text" name="keyword" placeholder="Título del libro">
    <button type="submit">Buscar</button>
</form>

<?php if ($books): ?>
<ul>
<?php foreach ($books as $book): ?>
    <li><?= $book['title'] ?> (<?= $book['aviable'] ? 'Disponible' : 'No disponible' ?>)</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
