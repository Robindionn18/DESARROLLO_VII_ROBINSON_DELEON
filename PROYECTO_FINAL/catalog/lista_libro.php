<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../views/menu.php';
require_once '../ProjectManager.php';

$pm = new ProjectManager();

$order = $_GET['order'] ?? 'id';
$books = $pm->sortBooksBy($order);
?>

<h2>Catálogo de Libros</h2>

<form method="get">
    <select name="order">
        <option value="id">ID</option>
        <option value="title">Título</option>
        <option value="release_date">Fecha</option>
        <option value="category">Categoría</option>
        <option value="aviable">Disponibilidad</option>
    </select>
    <button type="submit">Ordenar</button>
</form>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Título</th>
    <th>Autor</th>
    <th>Categoría</th>
    <th>Fecha</th>
    <th>Disponible</th>
    <th>Acción</th>
</tr>

<?php foreach ($books as $book): ?>
<tr>
    <td><?= $book['id'] ?></td>
    <td><?= $book['title'] ?></td>
    <td><?= $book['author'] ?></td>
    <td><?= $book['category'] ?></td>
    <td><?= $book['release_date'] ?></td>
    <td><?= $book['aviable'] ? 'Sí' : 'No' ?></td>
    <td>
        <?php if ($book['aviable'] && isset($_SESSION['user_id'])): ?>
            <a href="reservar.php?book_id=<?= $book['id'] ?>">Reservar</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
