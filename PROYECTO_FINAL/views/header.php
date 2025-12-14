<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca</title>

  <!-- Bootstrap CSS (CDN, más fácil) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uri = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/TALLERES/PROYECTO_FINAL/index.php">Biblioteca</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">

        <li class="nav-item">
          <a class="nav-link <?= str_contains($uri, '/catalog') ? 'active' : '' ?>"
             href="/TALLERES/PROYECTO_FINAL/catalog/index.php">
             Catálogo
          </a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>

          <li class="nav-item">
            <a class="nav-link <?= str_contains($uri, 'mis_reservas') ? 'active' : '' ?>"
               href="/TALLERES/PROYECTO_FINAL/mis_reservas.php">
               Reservas
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= str_contains($uri, 'mis_prestamos') ? 'active' : '' ?>"
               href="/TALLERES/PROYECTO_FINAL/mis_prestamos.php">
               Préstamos
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= str_contains($uri, 'mis_multas') ? 'active' : '' ?>"
               href="/TALLERES/PROYECTO_FINAL/mis_multas.php">
               Multas
            </a>
          </li>

          <?php if ($_SESSION['role'] == 2): ?>
            <li class="nav-item">
              <a class="nav-link <?= str_contains($uri, '/admin') ? 'active' : '' ?>"
                 href="/TALLERES/PROYECTO_FINAL/admin/books.php">
                 Administración
              </a>
            </li>
          <?php endif; ?>

        <?php endif; ?>
      </ul>

      <div class="d-flex">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a class="btn btn-outline-light me-2" href="/TALLERES/PROYECTO_FINAL/login.php">Login</a>
          <a class="btn btn-success" href="/TALLERES/PROYECTO_FINAL/register.php">Registro</a>
        <?php else: ?>
          <a class="btn btn-danger" href="/TALLERES/PROYECTO_FINAL/logout.php">Salir</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container">
