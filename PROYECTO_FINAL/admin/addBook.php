<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../views/menu.php';

require_once '../ProjectManager.php';
$pm = new ProjectManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pm->addBook(
        $_POST['title'],
        $_POST['author'],
        $_POST['category'],
        $_POST['release_date'],
        $_POST['aviable']
    );

    echo "Libro agregado correctamente";
}
?>

<h2>Agregar Libro</h2>

<form method="post">
    <input name="title" placeholder="Título" required>
    <input name="author" placeholder="Autor" required>
    <input name="category" placeholder="Categoría" required>
    <input type="date" name="release_date" required>

    <select name="aviable">
        <option value="1">Disponible</option>
        <option value="0">No disponible</option>
    </select>

    <button type="submit">Guardar</button>
</form>
