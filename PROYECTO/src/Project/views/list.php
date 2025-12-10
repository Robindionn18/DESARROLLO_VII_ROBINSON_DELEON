<?php
// Iniciar buffer de salida

ob_start();
?>

<div class="task-list">
    <h2>Libros</h2>
    <a href="index.php?action=create" class="btn">Nuevo Libros</a>
    <ul>
        <?php foreach ($projects as $projects): ?>
            <li class="<?= $projects['is_completed'] ? 'completed' : '' ?>">
                <span><?= htmlspecialchars($projects['title']) ?></span>
                <span><?= htmlspecialchars($projects['description'] ?? "" ) ?></span>
                <div>
                    <a href="index.php?action=toggle&id=<?= $projects['id'] ?>" class="btn">
                        <?= $task['is_completed'] ? '✓' : '○' ?>
                    </a>
                    <a href="index.php?action=delete&id=<?= $projects['id'] ?>" class="btn" onclick="return confirm('¿Eliminar esta tarea?')">🗑</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


<?php

// Guardar el contenido del buffer en una variable content
$content = ob_get_clean();
// Iniciar el layout
require '../../views/layout.php';

?>